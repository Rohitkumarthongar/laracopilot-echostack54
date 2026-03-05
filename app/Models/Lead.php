<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    protected $fillable = ['lead_number', 'customer_id', 'name', 'email', 'phone', 'address', 'lead_source', 'package_id', 'estimated_value', 'roof_type', 'system_size', 'notes', 'status', 'assigned_to'];
    protected $casts = ['estimated_value' => 'decimal:2'];

    public function customer() { return $this->belongsTo(Customer::class); }
    public function package() { return $this->belongsTo(Package::class); }
    public function quotations() { return $this->hasMany(Quotation::class); }
}