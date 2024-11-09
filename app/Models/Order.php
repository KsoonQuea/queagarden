<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "orders";

    protected $fillable = [
        'order_code',
        'distributor_id',
        'total_payment',
        'payment_type'
    ];

    protected static function booted()
    {
        static::creating(function ($order) {
            // Generate a random order code and set it
            $order->order_code = 'ORD-' . strtoupper(uniqid());
        });
    }

    public function order_details() : HasMany {
        return $this->hasMany(OrderDetails::class, 'order_id', 'id');
    }

    public function distributor() :BelongsTo {
        return $this->belongsTo(Distributor::class);
    }
}
