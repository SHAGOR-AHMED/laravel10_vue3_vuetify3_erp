<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    public function scopeSearch($query, $val=''){
        return $query->where('employee_name', 'LIKE', '%'.$val.'%')
                    ->orWhere('email', 'LIKE', '%'.$val.'%');
    }
}
