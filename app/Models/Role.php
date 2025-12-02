<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use \App\Models\Demo\UserRole;

class Role extends Model
{

    // protected $appends = ['used'];

    // public function getUsedAttribute()
    // {
    //     if( UserRole::where('role_id', $this->id)->first() ){
    //         return true;
    //     }else{
    //         return false;
    //     }
    // }


    public function users(){
        return $this->hasOne(\App\Models\User::class,'role_id', 'id');
    }

    public function usedRole(){
        return $this->hasOne(\App\Models\UserRole::class, 'role_id', 'id');
    }


    public function scopeSearch($query, $val=''){
        return $query->where('name', 'LIKE', '%'.$val.'%');
    }

}