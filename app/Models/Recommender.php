<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class Recommender extends Model
{
    public function house()
    {
        return $this->belongsTo(House::class, 'house_id', 'id');
    }

    public function buyer()
    {
        return $this->belongsTo(Buyer::class, 'buyer_id', 'id');
    }

}
