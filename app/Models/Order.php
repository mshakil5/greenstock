<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function customer(){
        return $this->belongsTo('App\Models\Customer');
    }

    public function orderdetails(){
        return $this->hasMany('App\Models\OrderDetail');
    }

    // public function orderdetails()
    // {
    //     return $this->hasOne(OrderDetail::class, 'order_id', 'id');
    // }

    public function salesreturn(){
        return $this->hasMany('App\Models\SalesReturn');
    }

    public function serviceRequest(){
        return $this->belongsTo('App\Models\ServiceRequest');
    }

    public function transaction(){
        return $this->hasMany('App\Models\Transaction');
    }

    public function serviceAdditionalProduct(){
        return $this->hasMany('App\Models\ServiceAdditionalProduct');
    }

    public function company(){
        return $this->belongsTo('App\Models\Company');
    }

    public function service(){
        return $this->belongsTo('App\Models\Service');
    }
}
