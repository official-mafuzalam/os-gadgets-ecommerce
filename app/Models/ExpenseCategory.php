<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpenseCategory extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'is_active'];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Get all expenses under this category.
     */
    public function expenses()
    {
        return $this->hasMany(Expense::class, 'category_id');
    }
}