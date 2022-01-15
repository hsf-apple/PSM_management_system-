<?php

namespace App\Models;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class studentprofileModel extends Model
{
    use HasFactory;

    protected $table = 'studentprofile';

    protected $fillable= [
        'studentName',
        'studentPhone',
        'student_Skill',
        'skill_Level',
    ];


    protected $guard = ['user_id'];
    public $timestamps = false;

    public function inventoryusage()
    {
        return $this->hasMany('App\Models\inventoryUsage','studentId','studentId' );
    }

    public function logbook()
    {
        return $this->hasMany('App\Models\LogbookModel','studentId','studentId' );
    }

    public function updateStudent($data, $id)
    {
        $postupdate = studentprofileModel::whereid($id)->first();

        //retrive user Primary Key data by using session (get from LoginController)
        $getsession = $data->session()->get('userprimarykey');

        //create object of class model lectureprofileModel
        $user = new lectureprofileModel();

       //find the first user_id data (foreign key) in db (table: lectureprofile)
       $user = $user::where('user_id',$getsession)->firstOrFail();



        switch($data->submitbutton)
        {
            case 'Approve Request':

            $postupdate->status = "Approve";

           $user->inventoryusage()->save($postupdate);


            //get quantity value from inventoryitemModel model
            $valueInventoryitem = $postupdate->inventoryitem->quantity;

            //  latest quantity value  = quantity value -1
            $latestvalue = $valueInventoryitem - 1;

            //get itemId primary key
            $foreignkeyItemId = $postupdate->itemId;

            //find itemId in db
            $updateinventoryItem = inventoryitemModel::where('itemId',$foreignkeyItemId)->first();

            //update latest quantity value
            $updateinventoryItem->quantity = $latestvalue;

            //update data
            $updateinventoryItem->save();

            break;
            case 'Reject Request':

            $postupdate->status = "Reject";

            $user->inventoryusage()->save($postupdate);

            break;
        }

    }
}
