<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SalesOrder extends Model
{
    protected $fillable = ['order_number', 'quotation_id', 'customer_id', 'customer_name', 'customer_email', 'customer_phone', 'customer_address', 'total_amount', 'tax_amount', 'discount_amount', 'final_amount', 'status', 'payment_status', 'notes'];
    protected $casts = ['total_amount' => 'decimal:2', 'tax_amount' => 'decimal:2', 'final_amount' => 'decimal:2'];

    public function items() { return $this->hasMany(SalesOrderItem::class); }
    public function customer() { return $this->belongsTo(Customer::class); }
    public function quotation() { return $this->belongsTo(Quotation::class); }
    public function installation() { return $this->hasOne(Installation::class); }
}