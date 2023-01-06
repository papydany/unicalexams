<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class RegisterCourseResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
        'id'=>$this->id,
        'code'=>$this->	reg_course_code,
        'title'=>$this->reg_course_title,
        'unit'=>$this->reg_course_unit,
        'status'=>$this->reg_course_status,
        
        
        ];
    }
}
