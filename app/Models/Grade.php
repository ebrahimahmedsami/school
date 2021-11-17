<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Grade extends Model
{
    use HasTranslations;
    protected $fillable = ['name','notes','created_at','updated-at'];

    public $translatable = ['name'];
    protected $table = 'Grades';
    public $timestamps = true;

    public function classrooms(){
        return $this->hasMany('App\Models\Classroom','grade_id');
    }
}
