<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Subsistence extends Model
{
    use HasFactory;

    protected $fillable = [
        'paycheck_id',
        'is_paid',
        'amount',
        'from',
        'to',
    ];

    public function paycheck()
    {
        return $this->belongsTo(PayCheck::class);
    }

    public function getNumberDaysAttribute()
    {
        $formatted_dt1 = Carbon::parse($this->from)->format('Y-m-d');
        $formatted_dt2 = Carbon::parse($this->to)->format('Y-m-d');

        return Carbon::parse($formatted_dt2)->diffInDays(Carbon::parse($formatted_dt1)) + 1;
    }
}
