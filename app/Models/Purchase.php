<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    protected $table = 'expenses'; // Name of your database table

    // The attributes that are mass assignable
    protected $fillable = [
        'description', 
        'amount', 
        'date', 
        'category_id', // Optional: if you have categories for expenses
    ];

    // Define a relationship to the Category model (if applicable)
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Define any other relationships or methods as needed
}