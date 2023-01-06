<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class CourseRegResource extends Resource
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
            
            'code'=>$this->course_code,
            'title'=>$this->course_title,
            'unit'=>$this->course_unit,
            'status'=>$this->course_status,
            ];
    }
}
