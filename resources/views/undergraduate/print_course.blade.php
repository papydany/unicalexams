@extends('layouts.main')
@section('title','Preview Course ')
@section('content')
    <div class="content container">
        <div class="page-wrapper">
            <header class="page-heading clearfix">
                <h1 class="heading-title pull-left">Welcome <strong class="text-danger">{{ Auth::user()->surname.
         
                    "&nbsp;". Auth::user()->firstname."&nbsp;".Auth::user()->othername }}</strong></h1>
                <div class="breadcrumbs pull-right">
                    <ul class="breadcrumbs-list">
                        <li class="breadcrumbs-label">You are here:</li>
                        <li><a href="url('/')}}">Home</a><i class="fa fa-angle-right"></i></li>
                        <li class="current">Preview Course </li>
                    </ul>
                </div><!--//breadcrumbs-->
            </header>
        </div>
        <div class="row" style="margin-bottom: 20px;">
            <form class="form-horizontal" role="form" method="POST" target="_blank" action="{{ url('/view_register_course') }}" data-parsley-validate>
            {{ csrf_field() }}
                <div class="form-group">
                    <div class="col-sm-3">
                        {{!$next =$ss+1}}
                        <select name="session"  readonly class="form-control">
                            <option value="{{$ss}}">{{$ss." / ".$next}} Session</option>
                        </select>
                     
                    </div>
                    <div class="col-sm-3">
                        <select name="level" class="form-control" readonly>
                        <option value="{{$reg->level_id}}">{{$reg->level_id}}00 Level</option>
                    </select>
                    </div>

                    <div class="col-sm-3">
                        <select name="semester" class="form-control" required>
                            <option value="">-- Select Semester --</option>
                            @if(isset($s))
                                @foreach($s as $v)
                                    <option value="{{$v->semester_id}}">{{$v->semester_name}}</option>

                                @endforeach

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