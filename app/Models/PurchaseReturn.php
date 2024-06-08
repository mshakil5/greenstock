<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseReturn extends Model
{
    use HasFactory;

    public function product()
    {
        return $this->belongsTo('App\Models\Product')->select('*');
    }


    public function purchasehistory(){
        return $this->belongsTo('App\Models\PurchaseHistory');
    }
}
