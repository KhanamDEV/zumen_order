<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    protected $table = 'feedbacks';

    public function project(){
        return $this->belongsTo(Project::class, 'project_id', 'id');
    }

    public function worker(){
        return $this->belongsTo(Worker::class);
    }


}
