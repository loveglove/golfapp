@extends('layouts.master')

@section('content')

             <div class="middle-box text-center animated fadeIn">
                <div class="title"> 
                    <img class="avatar" src="{{Auth::user()->avatar }}" height="70" width="70" />&nbspWelcome
                </div>
                <div>
                    <h2><b>{{Auth::user()->name }} </b></h2>
                     <p>Looks like you haven't joined a team yet! Create a new team by entering a team name below, <b>OR</b> join an existing team from the drop down list to continue.
                    </p>
                    <br />

                    {!! Form::open(array('route' => 'create_team', 'class' => 'form')) !!}
                    <div class="form-group {{ $errors->has('teamname') ? ' has-error' : '' }}">
                        {!! Form::text('teamname', null, ['class' => 'form-control', 'placeholder' => 'Enter new team...']) !!}
                        @if ($errors->has('teamname'))
                            <span class="help-block">
                                <strong>{{ $errors->first('teamname') }}</strong>
                            </span>
                        @endif
                        <br/>
                        {{Form::button('<i class="fa fa-user"></i> Create Team', array('type' => 'submit', 'class' => 'btn btn-primary block full-width m-b dim'))}}
                    </div>      
                    {!! Form::close() !!}
                    <br/>
                    {!! Form::open(array('route' => 'join_team', 'class' => 'form')) !!}
                    
                    <div class="form-group {{ $errors->has('join') ? ' has-error' : '' }}">
                        {!! Form::select('team', $teams, null, ['class' => 'form-control', 'placeholder' => 'Join existing team...']) !!}
                        @if ($errors->has('join'))
                            <span class="help-block">
                                <strong>{{ $errors->first('join') }}</strong>
                            </span>
                        @endif
                        <br/>
                        {{Form::button('<i class="fa fa-user"></i><i class="fa fa-user"></i> Join Team', array('type' => 'submit', 'class' => 'btn btn-primary block full-width m-b dim'))}}
                    </div>      
                    {!! Form::close() !!}

                    

                </div>
            </div>        
            <br/>
        <br/>

<script>
    $(".nav-btn, .count-info").hide();
</script>

@endsection