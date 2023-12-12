<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $table = 'projects';

    public function order(){
        return $this->hasOne(Order::class);
    }

    public function user(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

//    public function feedbacks(){
//        return $this->hasMany(Feedback::class);
//    }
}
