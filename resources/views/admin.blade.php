@extends('layouts.master')

@section('scripts')
	

@endsection

@section('content')
<br/>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="ibox float-e-margins">
        <div class="ibox-content">
  		    <h3><i class="fa fa-flag"></i> Tournament </h3>
            {{ Form::open(array('route' => 'create_tournament', 'class' => 'form')) }}
            <div class="form-group">
                {{ Form::text('tournament', null, ['class' => 'form-control', 'placeholder' => 'Tournament name...']) }}
                <br/>
                {{ Form::select('type', array('traditional' => 'Traditional', 'stroke' => 'Stroke', 'skins' => 'Skins', 'match' => 'Match'), null, ['class' => 'form-control', 'placeholder' => 'Tournament type...']) }}
                            <br/>
                {{ Form::select('course', array('1' => 'Milcroft', '2' => 'Bellmere Winds', '3' => 'Glendale'), null, ['class' => 'form-control', 'placeholder' => 'Course..']) }}
                <br/>
                {{ Form::checkbox('active', '1') }}&nbsp{{ Form::label('cbx', 'Active') }}
                <br/>
                <br/>
                {{ Form::button('<i class="fa fa-plus"></i> Create Tournament', array('type' => 'submit', 'class' => 'btn btn-primary block full-width m-b dim')) }}
            </div>      
            {{ Form::close() }}
            <br/>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Name </th>
                            <th>Status</th>
                            <th>Enable</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($tournaments as $tournament)
                        <tr>
                            <td>{{ $tournament->name }}</td>
                            <td>
                                @if($tournament->active == 1)
                                    <span class="green-text" ><strong>Active</strong></span>
                                @else 
                                    <span>-</span>
                                @endif
                            </td>
                            <td>
                                {{ Form::open(array('route' => 'activate_tour', 'class' => 'form')) }}
                                {{ Form::hidden('tour_id', $tournament->id) }}
                                {{ Form::button('<i class="fa fa-check"></i> ', array('type' => 'submit')) }}
                                {{ Form::close() }}
                                </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <br/>
            <p><strong>Active Type:</strong> {{ $active_tour->type }}</p>
        </div>
    </div>

<!--     <div class="ibox float-e-margins">
        <div class="ibox-content">
            <h3><i class="fa fa-trophy"></i>  Match Ups </h3>
            <br/>
            {{ Form::open(array('route' => 'create_matchup', 'class' => 'form')) }}
            <div class="form-group">  
                {{ Form::select('team1', $teams, null, ['class' => 'form-control', 'placeholder' => 'Team...']) }}
                <span class="green-text center"><h2><strong>vs</strong></h2></span>
                {{ Form::select('team2', $teams, null, ['class' => 'form-control', 'placeholder' => 'Team..']) }}
                <br/>
                <br/>
                <div>
                {{ Form::button('<i class="fa fa-plus"></i> Create Matchup', array('type' => 'submit', 'class' => 'btn btn-primary block full-width m-b dim')) }}
            </div>      
            {{ Form::close() }}
             <br/>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>Team1 </th>
                        <th></th>
                        <th>Team2</th>
                        <th>Edit</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($matchups as $matchup)
                        <tr>
                            <td>{{ $matchup->name1 }}</td>
                            <td class="green-text">vs</td>
                            <td>{{ $matchup->name2 }}</td>
                            <td>
                                {{ Form::open(array('route' => 'delete_matchup', 'class' => 'form')) }}
                                {{ Form::hidden('matchup', $matchup->id) }}
                                {{ Form::button('<i class="fa fa-times"></i> ', array('type' => 'submit')) }}
                                {{ Form::close() }}
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div> -->
    
    <div class="ibox float-e-margins">
        <div class="ibox-content">
            <h3><i class="fa fa-users"></i> Teams </h3>
            <br/>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Edit</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($allteams as $team)
                        <tr>
                            <td>{{ $team->name }}</td>
                            <td>
                                <a href="/team/edit/{{ $team->id }}"><button><i class="fa fa-edit"></i></button></a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
 
    <div class="ibox float-e-margins">
        <div class="ibox-content">
            <h3><i class="fa fa-bullseye"></i> Score</h3>
            <div class="form-group">
            {{ Form::open(array('route' => 'update_score', 'class' => 'form')) }}
                {{ Form::select('team', $teams, null, ['class' => 'form-control', 'placeholder' => 'Team..']) }}
                <br/>
                <div class="row">
                    <div class="col-xs-6">
                        <input type="tel" name="hole" class="form-control" placeholder="Hole #" />
                    </div>
                    <div class="col-xs-6">
                        <input type="tel" name="value" class="form-control" placeholder="Strokes #" />
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-xs-12">
                        {{ Form::select('value_text', array('-2' => 'eagle', '-1' => 'birdie', '0' => 'par', '+1' => 'bogey', '+2' => 'double'), null, ['class' => 'form-control', 'placeholder' => 'Strokes name...']) }}
                    </div>
                </div>
                <br/>
                {{ Form::button('<i class="fa fa-exclamation-triangle"></i> Update Score', array('type' => 'submit', 'class' => 'btn btn-primary block full-width m-b dim')) }}
            </div>      
            {{ Form::close() }}
        </div>
    </div>


   	<div class="ibox float-e-margins">
        <div class="ibox-content">
            <h3><i class="fa fa-star"></i> Awards</h3>
            <div class="form-group">
            {{ Form::open(array('route' => 'set_award', 'class' => 'form')) }}
                <br/>
                <div class="row">
                    <div class="col-xs-6">
                        <label for="ldm" > Mens Longest Drive </label>
                        <input type="tel" name="ldm" class="form-control" placeholder="Hole #" />
                    </div>
                    <div class="col-xs-6">
                        <label for="cpm" > Mens Closest Pin </label>
                        <input type="tel" name="cpm" class="form-control" placeholder="Hole #" />
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-xs-6">
                        <label for="ldw" > Womens Longest Drive </label>
                        <input type="tel" name="ldw" class="form-control" placeholder="Hole #" />
                    </div>
                    <div class="col-xs-6">
                        <label for="cpw" > Womens Closest Pin </label>
                        <input type="tel" name="cpw" class="form-control" placeholder="Hole #" />
                    </div>
                </div>
                <br/>
                {{ Form::button('<i class="fa fa-exclamation-triangle"></i> Set Holes', array('type' => 'submit', 'class' => 'btn btn-primary block full-width m-b dim')) }}
                @if ($errors->has('awards'))               
                    <small>{{ $errors->first('awards') }}</small>
                @endif
            </div>      
            {{ Form::close() }}
        </div>
    </div>

    <div class="ibox float-e-margins">
        <div class="ibox-content">
            <h3><i class="fa fa-times-circle"></i> Clear Tournament Scores</h3>
            <div class="form-group">
            {{ Form::open(array('route' => 'clear_tour', 'class' => 'form')) }}
                {{ Form::button('<i class="fa fa-exclamation-triangle"></i> Clear ALL Scores', array('type' => 'submit', 'class' => 'btn btn-danger block full-width m-b dim')) }}
            </div>      
            {{ Form::close() }}
        </div>
    </div>

    <br/>
    <br/>


</div>



@endsection