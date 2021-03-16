<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaximumBidAmounts extends Model
{
    protected $table = 'maximum_bid_amounts';
    protected $fillable = ['value','user_id'];
}
