<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ParchasePayment extends Model
{
    protected $fillable = ['amount','parchase_id'];
}
