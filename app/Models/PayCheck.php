<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayCheck extends Model
{
    use HasFactory;
    

    protected $fillable = [
    'site',
    'amount',
    'from',
    'to',
    'is_paid',
    ];

}
