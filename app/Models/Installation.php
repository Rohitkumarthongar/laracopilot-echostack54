<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Installation extends Model
{
    protected $fillable = ['installation_number', 'customer_id', 'sales_order_id', 'scheduled_date', 'completion_date', 'system_size_kw', 'installation_address', 'roof_type', 'assigned_team', 'status', 'notes', 'completion_photos'];
    protected $casts = ['scheduled_date' => 'date', 'completion_date' => 'date', 'completion_photos' => 'array'];

    public function customer() { return $this->belongsTo(Customer::class); }
    public function salesOrder() { return $this->belongsTo(SalesOrder::class); }
    public function serviceRequests() { return $this->hasMany(ServiceRequest::class); }
}