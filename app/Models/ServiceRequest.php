<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceRequest extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function company()
    {
        return $this->belongsTo('App\Models\Company');
    }

    public function order()
    {
        return $this->hasOne('App\Models\Order');
    }

    public function serviceRequestProduct()
    {
        return $this->hasMany('App\Models\ServiceRequestProduct');
    }




}
