<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Items extends Model
{
    protected $table = 'items';

    public function auto_biddings()
    {
        return $this->hasMany(AutoBids::class, 'item_id');
    }

    public function bids()
    {
        return $this->hasMany(Bids::class, 'item_id')->orderBy('price','asc');
    }
}
