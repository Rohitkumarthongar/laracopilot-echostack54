<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $fillable = ['employee_code', 'name', 'email', 'phone', 'department', 'designation', 'basic_salary', 'joining_date', 'address', 'is_active'];
    protected $casts = ['basic_salary' => 'decimal:2', 'joining_date' => 'date', 'is_active' => 'boolean'];

    public function salaryRecords() { return $this->hasMany(SalaryRecord::class); }
}