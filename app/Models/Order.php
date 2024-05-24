<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'grand_total',
        'payment_method',
        'payment_status',
        'status',
        'table_no'
    ];

    public function item()
    {
        return $this->hasMany(OrderItem::class);
    }
}
