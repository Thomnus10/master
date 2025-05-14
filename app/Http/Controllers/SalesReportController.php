<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SalesReportController extends Controller
{
    public function index(Request $request)
    {
        // Filters
        $startDate = $request->get('start_date', now()->startOfMonth()->toDateString());
        $endDate = $request->get('end_date', now()->endOfMonth()->toDateString());
        $period = $request->get('period', 'daily'); // daily, weekly, monthly

        // Determine the group format
        switch ($period) {
            case 'weekly':
                $groupFormat = DB::raw("YEARWEEK(orders.order_date, 1) as period_group");
                break;
            case 'monthly':
                $groupFormat = DB::raw("DATE_FORMAT(orders.order_date, '%Y-%m') as period_group");
                break;
            default:
                $groupFormat = DB::raw("DATE(orders.order_date) as period_group");
                break;
        }

        $sales = Payment::join('orders', 'payments.order_id', '=', 'orders.id')
            ->whereBetween('orders.order_date', [$startDate, $endDate])
            ->select([
                $groupFormat,
                'payments.payment_method',
                DB::raw('SUM(payments.total_amount) as total_sales'),
                DB::raw('COUNT(DISTINCT orders.id) as total_orders')
            ])
            ->groupBy('period_group', 'payments.payment_method')
            ->orderBy('period_group')
            ->get()
            ->groupBy('period_group');

        // Prepare data for the bar chart
        $labels = $sales->keys(); // X-axis labels (dates)
        $paymentTypes = $sales->flatten()->pluck('payment_method')->unique(); // payment types
        $datasets = [];

        foreach ($paymentTypes as $type) {
            $data = [];

            foreach ($labels as $label) {
                $group = $sales[$label]->firstWhere('payment_method', $type);
                $data[] = $group ? $group->total_sales : 0;
            }

            $datasets[] = [
                'label' => $type,
                'data' => $data,
                'backgroundColor' => '#' . substr(md5($type), 0, 6), // Random color based on type
            ];
        }

        return view('admin.sales_report.index', compact('sales', 'startDate', 'endDate', 'period', 'labels', 'datasets'));
    }
}
