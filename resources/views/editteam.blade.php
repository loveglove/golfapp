@extends('layouts.master')

@section('content')
<br/>
<div class="wrapper wrapper-content animated fadeInRight">
                <a href="/admin" class="form-group btn btn-link"><i class="fa fa-chevron-left"></i> Back</a>

    <div class="ibox float-e-margins">
        <div class="ibox-content">
  		    <h3><i class="fa fa-edit"></i> Edit Name 
            </h3>

            <br>
            <div class="row">
                <div class="col-xs-12">
                <!-- Save Name -->
                {{ Form::open(array('route' => 'update_name', 'class' => 'form')) }}
                    {{ Form::hidden('id', $team->id) }}
                    <input type="text" name="name" class="form-control" value="{{ $team->name }}" /></p>
                    <button class="btn btn-primary" type="submit"><i class="fa fa-check"></i> Save Name</button>
                    @if ($errors->has('name'))               
                        <small>{{ $errors->first('name') }}</small>
                    @endif
                {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
    <div class="ibox float-e-margins">
        <div class="ibox-content">
            <h3><i class="fa fa-users"></i> Manage Members </h3>
            <hr>
            @if(!empty($members))
                @foreach($members as $member)
                    <div class="row">
                        <div class="col-xs-8">
                            <!-- Save Name -->
                            <h4>{{ $member["name"] }}</h4>
                        </div>
                        <div class="col-xs-4" style="float:right;">
                            <!-- Clear Score -->
                    <!-- Clear Score -->
                                {{ Form::open(array('route' => 'eject_member', 'class' => 'form')) }}
                                {{ Form::hidden('team_id', $team->id) }}
                                {{ Form::hidden('user_id', $member["id"]) }}
                                <button class="btn btn-sm btn-warning" type="submit"><i class="fa fa-eject"></i> Remove</button>
                            {{ Form::close() }}
                        </div>
                    </div>
                    <hr>
                @endforeach
            @else
                <p> No Team Members Yet</p>
            @endif

            <br>
        </div>
    </div>
    <div class="ibox float-e-margins">
        <div class="ibox-content">
            <h3><i class="fa fa-times-circle"></i> Clear Team Score </h3>
            <br>
            <div class="row">
                <div class="col-xs-12">
                <!-- Clear Score -->
                {{ Form::open(array('route' => 'clear_team', 'class' => 'form')) }}
                {{ Form::hidden('id', $team->id) }}
                    <button class="btn btn-danger" type="submit"><i class="fa fa-times-circle"></i> Clear Score</button>
                     @if ($errors->has('clear'))               
                        <p>{{ $errors->first('clear') }}</p>
                    @endif
                {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>

    <div class="ibox float-e-margins">
        <div class="ibox-content">
            <h3><i class="fa fa-trash"></i> Delete Team </h3>
            <br>
            <div class="row">
                <div class="col-xs-12">
                <!-- Clear Score -->
                    {{ Form::open(array('route' => 'delete_team', 'class' => 'form')) }}
                    {{ Form::hidden('team', $team->id) }}
                    <button class="btn btn-secondary btn-sm" type="submit"><i class="fa fa-times"></i> Delete Team</button>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>

 

</div>


@endsection

@section('scripts')
    

@endsection