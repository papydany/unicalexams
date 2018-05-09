<!DOCTYPE html>
<html lang="en">
<head>
    <title>Course Form</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{URL::to('assets/plugins/bootstrap/css/bootstrap.min.css')}}">

</head>
<style>
    .mtop{margin-top:15px;}
    .b{font-weight: bolder;color: #000000}

    @media print {
        .w{width: 20%;float:left;}
        .w1{width: 60%;float:left;}
        .ww{width: 20%;float:right;}
        .w11{width: 30%;float:left;}
        .w111{width: 35%;float:left; }
        .ww11{width: 35%;float:right;}
        .ff{width: 33%;float:left}

        .clear{clear: both}
        p{font-size: 12px;}
        .mtop{margin-top:25px;}
        .text-center{text-align: center}
    }
</style>
<body>

<div class="row">
    <div class="col-sm-12 col-md-10 col-md-offset-1 mtop">
        <div class="col-sm-2 w"> <img id="logo" src="assets/images/logo.png" alt="Logo"/></div>
        <div class="col-sm-8 w1">
            <h3 class="text-center b">UNIVERSITY OF CALABAR</h3>
            <h4 class="text-center b">COURSE REGISTRATION FORM</h4>
            <h4 class="text-center b">{{$p->programme_name}}</h4>


        </div>
        <div class="col-sm-2 ww"> <img class="img-responsive" src="{{asset('img/student/'.Auth::user()->image_url)}}" alt=""/></div>

    </div>
    <div class="clear"></div>
    <div class="col-sm-12 col-md-10 col-md-offset-1 mtop">
        <div class="col-sm-3  w11"> {{! $next_ss = $ss+1}}
            <p class="text-justify b"><b>Session :</b>{{$ss." / ".$next_ss }} </p>
            <p class="text-justify b"><b>Level :</b>{{$l}}00 </p>
            <p class="text-justify b"><b>Semester : </b>{{$s->semester_name}}</p>
        </div>
        <div class="col-sm-5 w111 ">
            <h4 class="text-center b">{{ strtoupper(Auth::user()->surname).
                    "&nbsp;". strtoupper(Auth::user()->firstname)."&nbsp;".strtoupper(Auth::user()->othername) }}</h4>
            <p class="text-center b">{{Auth::user()->matric_number}}</p>
        </div>
        <div class="col-sm-4 ww11">
            <p class="text-justify b">Faculty &nbsp;:{{$f->faculty_name}}</p>
            <p class="text-justify b">Department&nbsp;:{{$d->department_name}}</p>
            <p class="text-justify b">Field Of Study&nbsp;:{{$fs->fos_name}}</p>
        </div>
        <div class="clear"></div>
     </div>
    <div class="table-responsive col-sm-12 col-md-10 col-md-offset-1 mtop">


        @if(isset($c))
            @if(count($c) > 0)


                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>Code</th>
                            <th>Unit</th>
                            <th>Status</th>
                          
                        </tr>
                        </thead>
                        <tbody>
                        {{!!$no = 0}}
                        @foreach($c as $v)
                            {{!++$no}}

                                <tr>

                                    <td>{{$no}}</td>
                                    <td>{{strtoupper($v->course_title)}}</td>
                                    <td>{{strtoupper($v->course_code)}}</td>
                                    <td>{{$v->course_unit}}</td>
                                    <td>{{$v->course_status}}</td>
                                   
                                </tr>
                                @endforeach
                        <tr>
                            <td colspan="3">Total Unit</td>
                            <td colspan="2">{{$c->sum('course_unit')}} Unit</td>
                        </tr>

                        </tbody>
                    </table><!--//table-->
                <div class="col-sm-12">
                 <div class="col-sm-4 ff">
                   <p> H O D Signature _____________________<p>
                    <p> Date ______________________________ </p>
                     </div>
                    <div class="col-sm-5 ff">
                        <p> Exam Officer Signature______________</p>
                        <p>Date ___________________________</p>

                    </div>
                       <div class="col-sm-3">
              <p><b class="text-danger">Course Status</b><br/>
            <b>C : </b>Compulsary<br/>
                 <b>E : </b>Elective</br/>
                  <b>R : </b>Failed course In Last Session<br/>
                    <b>D : </b>Drop course In Last Session</p>
          </div>
                    <div class="clearfix"></div>
                </div>






            @else
                <div class=" col-sm-10 col-sm-offset-1 alert alert-warning" role="alert">
                    No course is avalable for registeration in these semester. make sure your selected the right parameter<br/>
                    <strong>Thank you.... Unical exam portal Admin</strong>
                </div>
            @endif
        @endif
    </div>

</div>




</body>


</html>