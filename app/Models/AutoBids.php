<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AutoBids extends Model
{
    protected $table = 'auto_bids';
    protected $fillable = ['user_id', 'item_id'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
