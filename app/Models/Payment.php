<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payment extends Model
{
    use HasFactory;

    protected $table = 'payments';

    protected $primaryKey = 'id';

    protected $fillable = [
        'order_id',
        'employee_id',
        'total_amount', // This is the correct column name
        'payment_date',
        'payment_method',
        'payment_reference_number',
    ];

    protected $casts = [
        'payment_date' => 'datetime',
        'total_amount' => 'decimal:2', // Changed from 'amount' to 'total_amount'
        'payment_method' => 'string',
    ];

    public $timestamps = false;

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