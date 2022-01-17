<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class lectureprofileModel extends Model
{
    protected $table = 'lectureprofile';
    use HasFactory;

    protected $fillable= [
        'lectureName',
        'lecturePhone',
        'lecture_Skill',
        'skill_Level',
    ];

    protected $guard = ['user_id'];
    public $timestamps = false;


    public function fkStudent()
    {
        return $this->belongsTo('App\Models\studentprofileModel','studentId','studentId');
    }




    public function inventoryusage()
    {
        return $this->hasMany('App\Models\inventoryUsage','lectureId','lectureId');
    }

    public function expertiseFK(){
        return $this -> hasMany('App\Models\ExpertiseModel', 'lectureId', 'lectureId');
    }

    public function title()
    {
        return $this->hasMany('App\Models\TitleModel','lectureId','lectureId');
    }

    public function logbook()
    {
        return $this->hasMany('App\Models\LogbookModel','lectureId','lectureId' );
    }

    public function userid()
    {
        return $this->belongsTo('App\Models\User','user_id','id');
    }

     //index

     public function changetitle1($data)
    {
        $updateprofile = lectureprofileModel::Select()->where('user_id',$data)->get();

        return $updateprofile;
    }



}
