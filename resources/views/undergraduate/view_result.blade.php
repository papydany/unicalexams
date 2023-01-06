@extends('layouts.main')
@section('title','Result ')
@section('content')
   <div class="content container" style="min-height: 425px;">
        <div class="page-wrapper">
            <header class="page-heading clearfix">
                <h4 class="text-center text-primary"><b><u>VIEW RESULT</u></b></h4>
                
                    <h4 class="heading-title pull-left"><strong class=''>{{ strtoupper(Auth::user()->surname.
             
                        " ". Auth::user()->firstname." ".Auth::user()->othername )}}</strong>
                        <strong class="text-primary">{{Auth::user()->matric_number}}</strong></h4>
                    <div class="breadcrumbs pull-right">
                        <ul class="breadcrumbs-list">
                            <li class="breadcrumbs-label">You are here:</li>
                            <li><a href="{{url('/')}}">Home</a><i class="fa fa-angle-right"></i></li>
                            <li class="current">View Result </li>
                        </ul>
                    </div><!--//breadcrumbs-->
            </header>
        </div>
        <div class="row" style="margin-bottom: 20px;">
            <form class="form-horizontal" role="form" method="POST" target="_blank" action="{{ url('/view_result') }}" data-parsley-validate>
            {{ csrf_field() }}
                <div class="form-group">
                    <div class="col-sm-3 m10px">
                        
                        <select name="session"   class="form-control" required>
                            <option value="">-- Select Session --</option>
                            @if(isset($studentreg))
                            @foreach ($studentreg as $item)
                            {{!$next = $item->session + 1}}
                            <option value="{{$item->session}}">{{$item->session." / ".$next}} session</option>
                           
                            @endforeach
                            @endif
                        </select>
                     
                    </div>
                    <div class="col-sm-3 m10px">
                        <select name="level" class="form-control" required>
                            <option value="">-- Select Level --</option>
                            @if(isset($studentreg))
                            {{$i = 1}}
                            @foreach ($studentreg as $v)
                            
                            @if(Auth::user()->faculty_id == 14 &&  $v->level_id < 7)
                            @if($v->level_id < 3)

                            <option value="{{$v->level_id}}">{{$v->level_id}}00</option>
                          
                            @else
                            <option value="{{$v->level_id}}">PART {{$i++}}</option>
                          
                            @endif
                             @if($v->level_id == 6)
                               @break;
                               @endif
                            @else
                                <option value="{{$v->level_id}}">{{$v->level_id}}00</option>
                            @endif
                           
                            @endforeach
                            @endif
                           
                        </select>
                    </div>
                    <div class="col-sm-2 m10px">
                        <select name="season" class="form-control" required>
                            <option value="">Select Season</option>
                            <option value="NORMAL">NORMAL</option>
                            @if(Auth::user()->programme_id == 2)
                            <option value="RESIT">RESIT</option>

                            @else
                            @if(Auth::user()->faculty_id == 14)
                            <option value="VACATION">RESIT</option>
                            @else
                           <option value="VACATION">VACATION</option>
                           @endif
                            @endif
                        </select>
                    </div>

                    
                   <div class="col-sm-3 m10px">
                   <input type="submit" class="btn" value="Continue">
                   </div>

                </div>

            </form>

    </div>
    </div>
@endsection