<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'transaction_id',
        'payment_method',
        'amount',
        'status',
        'payment_details'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'payment_details' => 'array'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function markAsCompleted($transactionId = null)
    {
        $this->status = 'completed';
        if ($transactionId) {
            $this->transaction_id = $transactionId;
        }
        $this->save();

        $this->order->markAsPaid();

        return $this;
    }

    public function markAsFailed()
    {
        $this->status = 'failed';
        $this->save();

        return $this;
    }

    public function isSuccessful()
    {
        return $this->status === 'completed';
    }
}