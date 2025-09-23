<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'category_id',
        'amount',
        'description',
        'date',
        'inserted_by',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'date' => 'date',
    ];

    /**
     * Get the category that this expense belongs to.
     */
    public function category()
    {
        return $this->belongsTo(ExpenseCategory::class, 'category_id');
    }

    /**
     * Get the user who inserted this expense.
     */
    public function insertedBy()
    {
        return $this->belongsTo(User::class, 'inserted_by');
    }
}