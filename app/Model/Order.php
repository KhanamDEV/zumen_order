<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'project_id', 'worker_id', 'status', 'documents'
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function worker(){
        return $this->belongsTo(Worker::class);
    }
}
