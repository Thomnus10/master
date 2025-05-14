<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payment extends Model
{
    use HasFactory;

    protected $table = 'payments'; // Default pluralized table name

    protected $primaryKey = 'id'; // You can change this if using a different primary key

    protected $fillable = [
        'order_id',
        'employee_id',
        'total_amount',
        'payment_date',
        'payment_method',
        'payment_reference_number',
    ];

    protected $casts = [
        'payment_date' => 'datetime',
        'amount' => 'decimal:2',
        'payment_method' => 'string',
    ];

    public $timestamps = false; // Since you're using a `payment_date` field instead of created_at/updated_at

    // Relationships
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
