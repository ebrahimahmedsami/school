<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Classroom extends Model
{
    use HasTranslations;
    protected $fillable = ['name','grade_id','created_at','updated-at'];

    public $translatable = ['name'];
    protected $table = 'classrooms';
    public $timestamps = true;

    public function grade(){
        return $this->belongsTo('App\Models\Grade','grade_id');
    }
}
