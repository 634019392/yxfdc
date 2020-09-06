<?php

namespace App\Models;


class ClientRecord extends Base
{
    public function recommender()
    {
        return $this->belongsTo(Recommender::class, 'recommender_id', 'id');
    }
}
