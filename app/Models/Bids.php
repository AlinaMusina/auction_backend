<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bids extends Model
{
    protected $table = 'bids';
    protected $fillable = ['user_id','item_id','price'];
}
