@extends('layouts.main')
@section('title','Result ')
@section('content')
   <div class="content container" style="min-height: 425px;">
        <div class="page-wrapper">
            <header class="page-heading clearfix">
                <h1 class="heading-title pull-left">Welcome <strong class="text-danger">{{ Auth::user()->surname.
         
                    "&nbsp;". Auth::user()->firstname."&nbsp;".Auth::user()->othername }}</strong><strong class="text-success">({{Auth::user()->matric_number}})</strong></h1>
                <div class="breadcrumbs pull-right">
                    <ul class="breadcrumbs-list">
                        <li class="breadcrumbs-label">You are here:</li>
                        <li><a href="url('/')}}">Home</a><i class="fa fa-angle-right"></i></li>
                        <li class="current">View Result </li>
                    </ul>
                </div><!--//breadcrumbs-->
            </header>
        </div>
        <div class="row" style="margin-bottom: 20px;">
            <form class="form-horizontal" role="form" method="POST" target="_blank" action="{{ url('/view_result') }}" data-parsley-validate>
            {{ csrf_field() }}
                <div class="form-group">
                    <div class="col-sm-3">
                        
                        <select name="session"   class="form-control">
                            @if(isset($studentreg))
                            @foreach ($studentreg as $item)
                            {{!$next = $item->session + 1}}
                            <option value="{{$item->session}}">{{$item->session." / ".$next}} session</option>
                           
                            @endforeach
                            @endif
                        </select>
                     
                    </div>
                    <div class="col-sm-3">
                        <select name="level" class="form-control" required>
                            <option value="">-- Select Level --</option>
                            @if(isset($l))
                            {{$i = 1}}
                                @foreach($l as $k => $v)
                                @if(Auth::user()->faculty_id == 14 &&  $v->level_id < 7)
                                @if($v->level_id < 3)

                                <option value="{{$v->level_id}}">{{$v->level_name}}</option>
                              
                                @else
                                <option value="{{$v->level_id}}">PART {{$i++}}</option>
                              
                                @endif
                                 @if($v->level_id == 6)
                                   @break;
                                   @endif
                                @else
                                    <option value="{{$v->level_id}}">{{$v->level_name}}</option>
                                @endif
                                @endforeach

                           @endif
                        </select>
                    </div>
                    <div class="col-sm-2">
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

                    
                   <div class="col-sm-3">
                   <input type="submit" class="btn" value="Continue">
                   </div>

                </div>

            </form>

    </div>
    </div>
@endsection