<?php
namespace App\Models\Student;
use Illuminate\Database\Eloquent\Model;

/**
 * Created by PhpStorm.
 * User: binbinlan
 * Date: 25/02/2017
 * Time: 17:59
 */
class Student extends Model
{
    protected $table = 'student';

    public $timestamps = false;

    public function getlist(){
        return self::get();
    }

}