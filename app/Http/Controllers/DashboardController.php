<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Product;
use App\Models\Employee;
use App\Models\Supplier;
use App\Models\ProductRequest;
use App\Models\Discount;
use App\Models\Inventory;
use App\Models\Order;
use App\Models\OrderProduct;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Date ranges
        $today = Carbon::today();
        $yesterday = Carbon::yesterday();
        $weekStart = Carbon::now()->startOfWeek();
        $monthStart = Carbon::now()->startOfMonth();
        $currentMonth = Carbon::now()->format('F Y');
        $products = Product::all();

        // Orders & Sales - Include employee relationship
        $todayOrders = Order::with('employee')->whereDate('created_at', $today)->count();
        $todaySales = Order::whereDate('created_at', $today)->sum('total_amount');
        $yesterdaySales = Order::whereDate('created_at', $yesterday)->sum('total_amount');
        $weeklyRevenue = Order::whereBetween('created_at', [$weekStart, $today])->sum('total_amount');
        $monthlyRevenue = Order::whereBetween('created_at', [$monthStart, $today])->sum('total_amount');

        // Calculate sales change percentage
        $salesChange = 0;
        if ($yesterdaySales > 0) {
            $salesChange = round((($todaySales - $yesterdaySales) / $yesterdaySales) * 100, 1);
        }

        // Average order value
        $avgOrderValue = $todayOrders > 0 ? round($todaySales / $todayOrders, 2) : 0;

        // Staff stats - Include full names
        $totalCashiers = Employee::with('position')
            ->whereHas('position', function ($query) {
                $query->where('id', 2);
            })
            ->count();

        $totalManagers = Employee::with('position')
            ->whereHas('position', function ($query) {
                $query->where('id', 1);
            })
            ->count();

        // Inventory stats
        $outOfStockProducts = Inventory::where('quantity', 0)->count();
        $expiringSoonProducts = Inventory::where('expiration_date', '<=', Carbon::now()->addDays(7))
            ->where('expiration_date', '>=', Carbon::now())
            ->count();

        // Top selling products (last 7 days) - Include product relationships
        $topSellingProducts = DB::table('order_product')
            ->join('products', 'order_product.product_id', '=', 'products.id')
            ->leftJoin('categories', 'products.category_id', '=', 'categories.id')
            ->leftJoin('units', 'products.unit_id', '=', 'units.id')
            ->select(
                'products.id',
                'products.name',
                'categories.name as category_name',
                DB::raw('units.type as unit_type'),
                DB::raw('SUM(order_product.quantity) as total_quantity'),
                DB::raw('SUM(order_product.price * order_product.quantity) as total_revenue')
            )
            ->whereBetween('order_product.created_at', [Carbon::now()->subDays(7), Carbon::now()])
            ->groupBy('products.id', 'products.name', 'categories.name', 'units.type')
            ->orderByDesc('total_quantity')
            ->limit(5)
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'name' => $item->name,
                    'category' => $item->category_name ?? 'Uncategorized',
                    'unit' => $item->unit_type ?? 'N/A',
                    'quantity' => $item->total_quantity,
                    'revenue' => number_format($item->total_revenue, 2)
                ];
            });

        // Recent activities - Now with real data
        $recentActivities = Order::with(['employee'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get()
            ->map(function ($order) {
                $employeeName = $order->employee ?
                    trim("{$order->employee->Fname} {$order->employee->Mname} {$order->employee->Lname}") :
                    'Unknown';

                return (object) [
                    'icon' => 'shopping-cart',
                    'description' => 'Order #' . $order->id . ' placed by ' . $employeeName,
                    'time' => $order->created_at->diffForHumans()
                ];
            });

        // Chart data for sales overview
        $salesChartLabels = [];
        $salesChartData = [];

        // Generate last 7 days data for chart
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $salesChartLabels[] = $date->format('D');

            $dailySales = Order::whereDate('created_at', $date)->sum('total_amount');
            $salesChartData[] = $dailySales;
        }

        // Category breakdown chart
        $categoryData = DB::table('products')
            ->leftJoin('categories', 'products.category_id', '=', 'categories.id')
            ->select(
                'categories.name as category_name',
                DB::raw('count(*) as total')
            )
            ->groupBy('categories.name')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        // Prepare category labels and values
        $categoryLabels = $categoryData->pluck('category_name')->map(function ($name) {
            return $name ?? 'Uncategorized';
        })->toArray();

        $categoryValues = $categoryData->pluck('total')->toArray();

        return view('admin.dashboard', [
            // Original variables
            'totalUsers' => User::count(),
            'product' => $products,
            'totalProducts' => Product::count(),
            'lowStockProducts' => Inventory::where('quantity', '<', 10)->count(),
            'totalEmployees' => Employee::count(),
            'totalSuppliers' => Supplier::count(),
            'pendingRequests' => ProductRequest::where('status', 'pending')->count(),
            'activeDiscounts' => Discount::where('is_active', true)->count(),

            // Enhanced dashboard metrics
            'todaySales' => number_format($todaySales, 2),
            'weeklyRevenue' => number_format($weeklyRevenue, 2),
            'monthlyRevenue' => number_format($monthlyRevenue, 2),
            'todayOrders' => $todayOrders,
            'avgOrderValue' => number_format($avgOrderValue, 2),
            'salesChange' => $salesChange,
            'currentMonth' => $currentMonth,
            'outOfStockProducts' => $outOfStockProducts,
            'expiringSoonProducts' => $expiringSoonProducts,

            'totalCashiers' => $totalCashiers,
            'totalManagers' => $totalManagers,
            'topSellingProducts' => $topSellingProducts,
            'recentActivities' => $recentActivities,
            'salesChartLabels' => $salesChartLabels,
            'salesChartData' => $salesChartData,
            'categoryLabels' => $categoryLabels,
            'categoryData' => $categoryValues,
        ]);
    }

    public function getSalesData()
    {
        $period = request('period', 'week');
        $labels = [];
        $data = [];

        switch ($period) {
            case 'month':
                // Last 30 days data grouped by day
                $startDate = Carbon::now()->subDays(29);
                $endDate = Carbon::now();

                for ($date = $startDate; $date->lte($endDate); $date->addDay()) {
                    $labels[] = $date->format('d M');
                    $dailySales = Order::whereDate('created_at', $date)->sum('total_amount');
                    $data[] = $dailySales;
                }
                break;

            case 'quarter':
                // Last 3 months data grouped by week
                $startDate = Carbon::now()->subMonths(3)->startOfWeek();
                $endDate = Carbon::now();

                for ($date = $startDate; $date->lte($endDate); $date->addWeek()) {
                    $weekEnd = (clone $date)->addDays(6);
                    $labels[] = $date->format('d M') . ' - ' . $weekEnd->format('d M');

                    $weeklySales = Order::whereBetween('created_at', [$date, $weekEnd])->sum('total_amount');
                    $data[] = $weeklySales;
                }
                break;

            default: // week
                // Last 7 days data
                for ($i = 6; $i >= 0; $i--) {
                    $date = Carbon::now()->subDays($i);
                    $labels[] = $date->format('D');

                    $dailySales = Order::whereDate('created_at', $date)->sum('total_amount');
                    $data[] = $dailySales;
                }
                break;
        }

        return response()->json([
            'labels' => $labels,
            'data' => $data
        ]);
    }
}