<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $fillable = [
        'first_name', 'last_name', 'bio',
    ];

    public function user() {
        return $this->belongsTo('App\User');
    }
}
