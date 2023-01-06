<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class ResultResource extends Resource
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
            'ca'=>$this->ca,
            'exam'=>$this->exam,
            'total'=>$this->total,
            'grade'=>$this->grade,
            ];
    }
}
