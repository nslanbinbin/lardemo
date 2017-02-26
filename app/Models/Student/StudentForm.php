<?php
/**
 * Created by PhpStorm.
 * User: binbinlan
 * Date: 25/02/2017
 * Time: 18:12
 */

namespace App\Models\Student;


use Illuminate\Database\Eloquent\Model;

class StudentForm extends Model
{
    public function add()
    {
        for ($i = 0; $i < 89765; $i++) {
            $student = new Student();
            $student->name = 'sadf';
            $student->email = 'e'.$i.'a@qq.com';
            $bool = $student->save();
        }

    }

}