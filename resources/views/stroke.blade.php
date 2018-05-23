@extends('layouts.master')

@section('scripts')
	

@endsection

@section('content')


<style>
	.col-par,
	.col-hole{
		line-height:22px; 
		vertical-align:middle;
	}
	.col-container{
		padding-bottom:25px;
		height:auto;
	}

	.box-container{
		position: absolute; 
		left: 50%;
	}

	.square-border{
		border-color: #ff944d !important;
	}
	
	.circle-border{
		border-color: #6699ff !important;
		border-radius:50%;
	}

	.box-outer{
		border-width: 1px;
		border-style: solid;
		border-color:rgba(0,0,0,0);
		text-align: center;
		width:22px;
		height:22px;
		position: relative; 
		left: -50%;

	}

	.box-inner{
		border-width: 1px;
		border-style: solid;
		border-color:rgba(0,0,0,0);
		text-align: center;
		left:2px;
		top:2px;
		width:16px;
		height:16px;
		position: absolute;
		line-height:13px;
	}

	.standings-row{
		border-bottom:1px solid #f2f2f2; 
		padding:8px 2px 8px 2px; 	
	}
	.standings-header{
		border-bottom:1px solid silver; 
		padding:8px 2px 8px 2px; 	
	}

	.rank-col{
		font-size:20px; 
		font-weight:800;
	}
	.rank-sup{
		font-weight:500;
	}
	.name-col{
		
	}
	.score-col{
		padding:2px 0px 0px 0px;
		font-size:16px;
		vertical-align: right;
	}
	.hidden{
		display: none;
	}

</style>

<div class="wrapper wrapper-content animated fadeInRight">
	<br/>
  	<div class="row">
  <span style="text-align:center;"><h3>Stroke</h3></span>
  		<div class="col-md-6 col-lg-8">
	@if(!empty($standings))
		@foreach ($standings as $standing)
	  		<div class="ibox float-e-margins">
	            <div class="ibox-content">
					<div class="row standings-header">
						<div class="col-xs-2" style="padding-left:5px;"><strong>Rank</strong></div>
						<div class="col-xs-8" style="padding-left:5px;"><strong>Team</strong></div>
						<div class="col-xs-2" style="padding-left:5px;"><strong>Score</strong></div>
					</div>

				@if($standing[0]->rank == 1 && $standing[1]->rank == 2)
					<div class="row standings-row" onclick="getScoreCard('{{ $standing[0]->id_team }}');"> 
				@else
					<div class="row standings-row row-dull" onclick="getScoreCard('{{ $standing[0]->id_team }}');"> 
				@endif
						<div class="row">
							<div class="col-xs-2 rank-col">
								@if($standing[0]->rank == 1 && $standing[1]->rank == 1 )
									&nbspT
								@elseif($standing[0]->rank == 1 && $standing[1]->rank == 2)
									<span class="green-text">&nbspW</span>
								@else
									<span class="">&nbspL</span>
								@endif
							</div>
							<div class="col-xs-8 name-col">
								@if(!empty($standing[0]->user1_avatar))
									<img class="avatar" src="{{ $standing[0]->user1_avatar }}" height="30" width="30" /> 
								@elseif(!empty($standing[0]->user2_avatar))
									<img class="avatar" src="{{ $standing[0]->user2_avatar }}" height="30" width="30" /> 
								@else 
									<img class="avatar" src="images/empty_user.jpg" height="30" width="30" />
								@endif 
								&nbsp{{ $standing[0]->TeamName }}
							</div>
							<div class="col-xs-2 score-col"> 
								@if($standing[0]->rank == 0)
									<i class="fa fa-minus"></i>&nbsp{{ $standing[0]->score  }}
								@elseif($standing[0]->score < 0)
									<i class="fa fa-level-down green-text"></i>&nbsp{{ $standing[0]->score }}
								@elseif($standing[0]->score > 0)
									<i class="fa fa-level-up red-text"></i>&nbsp{{ $standing[0]->score }}
								@endif
							</div>
						</div>
					</div> 
					<input type="hidden" id="hidden_set{{ $standing[0]->id_team }}" value="0" />	   
					<div class="row" id="score{{ $standing[0]->id_team }}" style="display:none; text-align:center;">
						<br />
						<div class="col-xs-6"><strong>Front 9</strong>
							<div class="row">
								<div class="col-xs-4"><small><strong>Hole</strong></small></div>
								<div class="col-xs-4"><small><strong>Score</strong></small></div>
								<div class="col-xs-4"><small><strong>Par</strong></small></div>
							</div>
							<div class="row" id="sc_1_{{ $standing[0]->id_team }}">
								<div class="col-xs-4 col-hole">-</div>
								<div class="col-xs-4 col-container"> 
									<div class="box-container">
										<div class="box-outer">
											<div class="box-inner">-</div>
										</div>
									</div>
								</div>
								<div class="col-xs-4 col-par">-</div>
							</div>
							<div class="row" id="sc_2_{{ $standing[0]->id_team }}">
								<div class="col-xs-4 col-hole">-</div>
								<div class="col-xs-4 col-container"> 
									<div class="box-container">
										<div class="box-outer">
											<div class="box-inner">-</div>
										</div>
									</div>
								</div>
								<div class="col-xs-4 col-par">-</div>
							</div>
							<div class="row" id="sc_3_{{ $standing[0]->id_team }}">
								<div class="col-xs-4 col-hole">-</div>
								<div class="col-xs-4 col-container"> 
									<div class="box-container">
										<div class="box-outer">
											<div class="box-inner">-</div>
										</div>
									</div>
								</div>
								<div class="col-xs-4 col-par">-</div>
							</div>
							<div class="row" id="sc_4_{{ $standing[0]->id_team }}">
								<div class="col-xs-4 col-hole">-</div>
								<div class="col-xs-4 col-container"> 
									<div class="box-container">
										<div class="box-outer">
											<div class="box-inner">-</div>
										</div>
									</div>
								</div>
								<div class="col-xs-4 col-par">-</div>
							</div>
							<div class="row" id="sc_5_{{ $standing[0]->id_team }}">
								<div class="col-xs-4 col-hole">-</div>
								<div class="col-xs-4 col-container"> 
									<div class="box-container">
										<div class="box-outer">
											<div class="box-inner">-</div>
										</div>
									</div>
								</div>
								<div class="col-xs-4 col-par">-</div>
							</div>
							<div class="row" id="sc_6_{{ $standing[0]->id_team }}">
								<div class="col-xs-4 col-hole">-</div>
								<div class="col-xs-4 col-container"> 
									<div class="box-container">
										<div class="box-outer">
											<div class="box-inner">-</div>
										</div>
									</div>
								</div>
								<div class="col-xs-4 col-par">-</div>
							</div>
							<div class="row" id="sc_7_{{ $standing[0]->id_team }}">
								<div class="col-xs-4 col-hole">-</div>
								<div class="col-xs-4 col-container"> 
									<div class="box-container">
										<div class="box-outer">
											<div class="box-inner">-</div>
										</div>
									</div>
								</div>
								<div class="col-xs-4 col-par">-</div>
							</div>
							<div class="row" id="sc_8_{{ $standing[0]->id_team }}">
								<div class="col-xs-4 col-hole">-</div>
								<div class="col-xs-4 col-container"> 
									<div class="box-container">
										<div class="box-outer">
											<div class="box-inner">-</div>
										</div>
									</div>
								</div>
								<div class="col-xs-4 col-par">-</div>
							</div>
							<div class="row" id="sc_9_{{ $standing[0]->id_team }}">
								<div class="col-xs-4 col-hole">-</div>
								<div class="col-xs-4 col-container"> 
									<div class="box-container">
										<div class="box-outer">
											<div class="box-inner">-</div>
										</div>
									</div>
								</div>
								<div class="col-xs-4 col-par">-</div>
							</div>
						</div>
						<div class="col-xs-6"><strong>Back 9</strong>
							<div class="row">
								<div class="col-xs-4"><small><strong>Hole</strong></small></div>
								<div class="col-xs-4"><small><strong>Score</strong></small></div>
								<div class="col-xs-4"><small><strong>Par</strong></small></div>
							</div>
							<div class="row" id="sc_10_{{ $standing[0]->id_team }}">
								<div class="col-xs-4 col-hole">-</div>
								<div class="col-xs-4 col-container"> 
									<div class="box-container">
										<div class="box-outer">
											<div class="box-inner">-</div>
										</div>
									</div>
								</div>
								<div class="col-xs-4 col-par">-</div>
							</div>
							<div class="row" id="sc_11_{{ $standing[0]->id_team }}">
								<div class="col-xs-4 col-hole">-</div>
								<div class="col-xs-4 col-container"> 
									<div class="box-container">
										<div class="box-outer">
											<div class="box-inner">-</div>
										</div>
									</div>
								</div>
								<div class="col-xs-4 col-par">-</div>
							</div>
							<div class="row" id="sc_12_{{ $standing[0]->id_team }}">
								<div class="col-xs-4 col-hole">-</div>
								<div class="col-xs-4 col-container"> 
									<div class="box-container">
										<div class="box-outer">
											<div class="box-inner">-</div>
										</div>
									</div>
								</div>
								<div class="col-xs-4 col-par">-</div>
							</div>
							<div class="row" id="sc_13_{{ $standing[0]->id_team }}">
								<div class="col-xs-4 col-hole">-</div>
								<div class="col-xs-4 col-container"> 
									<div class="box-container">
										<div class="box-outer">
											<div class="box-inner">-</div>
										</div>
									</div>
								</div>
								<div class="col-xs-4 col-par">-</div>
							</div>
							<div class="row" id="sc_14_{{ $standing[0]->id_team }}">
								<div class="col-xs-4 col-hole">-</div>
								<div class="col-xs-4 col-container"> 
									<div class="box-container">
										<div class="box-outer">
											<div class="box-inner">-</div>
										</div>
									</div>
								</div>
								<div class="col-xs-4 col-par">-</div>
							</div>
							<div class="row" id="sc_15_{{ $standing[0]->id_team }}">
								<div class="col-xs-4 col-hole">-</div>
								<div class="col-xs-4 col-container"> 
									<div class="box-container">
										<div class="box-outer">
											<div class="box-inner">-</div>
										</div>
									</div>
								</div>
								<div class="col-xs-4 col-par">-</div>
							</div>
							<div class="row" id="sc_16_{{ $standing[0]->id_team }}">
								<div class="col-xs-4 col-hole">-</div>
								<div class="col-xs-4 col-container"> 
									<div class="box-container">
										<div class="box-outer">
											<div class="box-inner">-</div>
										</div>
									</div>
								</div>
								<div class="col-xs-4 col-par">-</div>
							</div>
							<div class="row" id="sc_17_{{ $standing[0]->id_team }}">
								<div class="col-xs-4 col-hole">-</div>
								<div class="col-xs-4 col-container"> 
									<div class="box-container">
										<div class="box-outer">
											<div class="box-inner">-</div>
										</div>
									</div>
								</div>
								<div class="col-xs-4 col-par">-</div>
							</div>
							<div class="row" id="sc_18_{{ $standing[0]->id_team }}">
								<div class="col-xs-4 col-hole">-</div>
								<div class="col-xs-4 col-container"> 
									<div class="box-container">
										<div class="box-outer">
											<div class="box-inner">-</div>
										</div>
									</div>
								</div>
								<div class="col-xs-4 col-par">-</div>
							</div>
						</div>
						<br />
					</div>

				@if($standing[1]->rank == 1 && $standing[0]->rank == 2)
					<div class="row standings-row" onclick="getScoreCard('{{ $standing[1]->id_team }}');"> 
				@else
					<div class="row standings-row row-dull" onclick="getScoreCard('{{ $standing[1]->id_team }}');"> 
				@endif
						<div class="row">
							<div class="col-xs-2 rank-col">
								@if($standing[1]->rank == 1 && $standing[0]->rank == 1 )
									&nbspT
								@elseif($standing[1]->rank == 1 && $standing[0]->rank == 2)
									<span class="green-text">&nbspW</span>
								@else
									<span class="">&nbspL</span>
								@endif
							</div>
							<div class="col-xs-8 name-col">
								@if(!empty($standing[1]->user1_avatar))
									<img class="avatar" src="{{ $standing[0]->user1_avatar }}" height="30" width="30" /> 
								@elseif(!empty($standing[1]->user2_avatar))
									<img class="avatar" src="{{ $standing[0]->user2_avatar }}" height="30" width="30" /> 
								@else 
									<img class="avatar" src="images/empty_user.jpg" height="30" width="30" />
								@endif 
								&nbsp{{ $standing[1]->TeamName }}
							</div>
							<div class="col-xs-2 score-col"> 
								@if($standing[1]->rank == 0)
									<i class="fa fa-minus"></i>&nbsp{{ $standing[1]->score  }}
								@elseif($standing[1]->score < 0)
									<i class="fa fa-level-down green-text"></i>&nbsp{{ $standing[1]->score }}
								@elseif($standing[1]->score > 0)
									<i class="fa fa-level-up red-text"></i>&nbsp{{ $standing[1]->score }}
								@endif
							</div>
						</div>
					</div> 
					<input type="hidden" id="hidden_set{{ $standing[1]->id_team }}" value="0" />	   
					<div class="row" id="score{{ $standing[1]->id_team }}" style="display:none; text-align:center;">
						<br />
						<div class="col-xs-6"><strong>Front 9</strong>
							<div class="row">
								<div class="col-xs-4"><small><strong>Hole</strong></small></div>
								<div class="col-xs-4"><small><strong>Score</strong></small></div>
								<div class="col-xs-4"><small><strong>Par</strong></small></div>
							</div>
							<div class="row" id="sc_1_{{ $standing[1]->id_team }}">
								<div class="col-xs-4 col-hole">-</div>
								<div class="col-xs-4 col-container"> 
									<div class="box-container">
										<div class="box-outer">
											<div class="box-inner">-</div>
										</div>
									</div>
								</div>
								<div class="col-xs-4 col-par">-</div>
							</div>
							<div class="row" id="sc_2_{{ $standing[1]->id_team }}">
								<div class="col-xs-4 col-hole">-</div>
								<div class="col-xs-4 col-container"> 
									<div class="box-container">
										<div class="box-outer">
											<div class="box-inner">-</div>
										</div>
									</div>
								</div>
								<div class="col-xs-4 col-par">-</div>
							</div>
							<div class="row" id="sc_3_{{ $standing[1]->id_team }}">
								<div class="col-xs-4 col-hole">-</div>
								<div class="col-xs-4 col-container"> 
									<div class="box-container">
										<div class="box-outer">
											<div class="box-inner">-</div>
										</div>
									</div>
								</div>
								<div class="col-xs-4 col-par">-</div>
							</div>
							<div class="row" id="sc_4_{{ $standing[1]->id_team }}">
								<div class="col-xs-4 col-hole">-</div>
								<div class="col-xs-4 col-container"> 
									<div class="box-container">
										<div class="box-outer">
											<div class="box-inner">-</div>
										</div>
									</div>
								</div>
								<div class="col-xs-4 col-par">-</div>
							</div>
							<div class="row" id="sc_5_{{ $standing[1]->id_team }}">
								<div class="col-xs-4 col-hole">-</div>
								<div class="col-xs-4 col-container"> 
									<div class="box-container">
										<div class="box-outer">
											<div class="box-inner">-</div>
										</div>
									</div>
								</div>
								<div class="col-xs-4 col-par">-</div>
							</div>
							<div class="row" id="sc_6_{{ $standing[1]->id_team }}">
								<div class="col-xs-4 col-hole">-</div>
								<div class="col-xs-4 col-container"> 
									<div class="box-container">
										<div class="box-outer">
											<div class="box-inner">-</div>
										</div>
									</div>
								</div>
								<div class="col-xs-4 col-par">-</div>
							</div>
							<div class="row" id="sc_7_{{ $standing[1]->id_team }}">
								<div class="col-xs-4 col-hole">-</div>
								<div class="col-xs-4 col-container"> 
									<div class="box-container">
										<div class="box-outer">
											<div class="box-inner">-</div>
										</div>
									</div>
								</div>
								<div class="col-xs-4 col-par">-</div>
							</div>
							<div class="row" id="sc_8_{{ $standing[1]->id_team }}">
								<div class="col-xs-4 col-hole">-</div>
								<div class="col-xs-4 col-container"> 
									<div class="box-container">
										<div class="box-outer">
											<div class="box-inner">-</div>
										</div>
									</div>
								</div>
								<div class="col-xs-4 col-par">-</div>
							</div>
							<div class="row" id="sc_9_{{ $standing[1]->id_team }}">
								<div class="col-xs-4 col-hole">-</div>
								<div class="col-xs-4 col-container"> 
									<div class="box-container">
										<div class="box-outer">
											<div class="box-inner">-</div>
										</div>
									</div>
								</div>
								<div class="col-xs-4 col-par">-</div>
							</div>
						</div>
						<div class="col-xs-6"><strong>Back 9</strong>
							<div class="row">
								<div class="col-xs-4"><small><strong>Hole</strong></small></div>
								<div class="col-xs-4"><small><strong>Score</strong></small></div>
								<div class="col-xs-4"><small><strong>Par</strong></small></div>
							</div>
							<div class="row" id="sc_10_{{ $standing[1]->id_team }}">
								<div class="col-xs-4 col-hole">-</div>
								<div class="col-xs-4 col-container"> 
									<div class="box-container">
										<div class="box-outer">
											<div class="box-inner">-</div>
										</div>
									</div>
								</div>
								<div class="col-xs-4 col-par">-</div>
							</div>
							<div class="row" id="sc_11_{{ $standing[1]->id_team }}">
								<div class="col-xs-4 col-hole">-</div>
								<div class="col-xs-4 col-container"> 
									<div class="box-container">
										<div class="box-outer">
											<div class="box-inner">-</div>
										</div>
									</div>
								</div>
								<div class="col-xs-4 col-par">-</div>
							</div>
							<div class="row" id="sc_12_{{ $standing[1]->id_team }}">
								<div class="col-xs-4 col-hole">-</div>
								<div class="col-xs-4 col-container"> 
									<div class="box-container">
										<div class="box-outer">
											<div class="box-inner">-</div>
										</div>
									</div>
								</div>
								<div class="col-xs-4 col-par">-</div>
							</div>
							<div class="row" id="sc_13_{{ $standing[1]->id_team }}">
								<div class="col-xs-4 col-hole">-</div>
								<div class="col-xs-4 col-container"> 
									<div class="box-container">
										<div class="box-outer">
											<div class="box-inner">-</div>
										</div>
									</div>
								</div>
								<div class="col-xs-4 col-par">-</div>
							</div>
							<div class="row" id="sc_14_{{ $standing[1]->id_team }}">
								<div class="col-xs-4 col-hole">-</div>
								<div class="col-xs-4 col-container"> 
									<div class="box-container">
										<div class="box-outer">
											<div class="box-inner">-</div>
										</div>
									</div>
								</div>
								<div class="col-xs-4 col-par">-</div>
							</div>
							<div class="row" id="sc_15_{{ $standing[1]->id_team }}">
								<div class="col-xs-4 col-hole">-</div>
								<div class="col-xs-4 col-container"> 
									<div class="box-container">
										<div class="box-outer">
											<div class="box-inner">-</div>
										</div>
									</div>
								</div>
								<div class="col-xs-4 col-par">-</div>
							</div>
							<div class="row" id="sc_16_{{ $standing[1]->id_team }}">
								<div class="col-xs-4 col-hole">-</div>
								<div class="col-xs-4 col-container"> 
									<div class="box-container">
										<div class="box-outer">
											<div class="box-inner">-</div>
										</div>
									</div>
								</div>
								<div class="col-xs-4 col-par">-</div>
							</div>
							<div class="row" id="sc_17_{{ $standing[1]->id_team }}">
								<div class="col-xs-4 col-hole">-</div>
								<div class="col-xs-4 col-container"> 
									<div class="box-container">
										<div class="box-outer">
											<div class="box-inner">-</div>
										</div>
									</div>
								</div>
								<div class="col-xs-4 col-par">-</div>
							</div>
							<div class="row" id="sc_18_{{ $standing[1]->id_team }}">
								<div class="col-xs-4 col-hole">-</div>
								<div class="col-xs-4 col-container"> 
									<div class="box-container">
										<div class="box-outer">
											<div class="box-inner">-</div>
										</div>
									</div>
								</div>
								<div class="col-xs-4 col-par">-</div>
							</div>
						</div>
						<br />
					</div>
	            </div>
	        </div>
		@endforeach
		@endif
	    </div>
	</div>
</div>
<?php $myTeam = Session::get('myteam')->name ?>
<?php $userID = Auth::user()->id; ?>
 <?php $userAvatar = Auth::user()->avatar; ?>
<script>

var myTeam = '<?php echo $myTeam ?>';

	function getScoreCard(team_id){	
		if($("#hidden_set" + team_id).val() == 0)
		{
	        $.ajax({
	            url: 'getScoreCard',
				type: "get",
				dataType: "json",
				data: {'team_id': team_id},
	            success: function(data){
	            	$("#hidden_set" + team_id).val(1);
	            	console.log(data);
	            	drawScoreCard(team_id, data);
	            },
	            error: function(error){
	            	console.log(error);
	            }
	        });    
        }  
        $("#score" + team_id).slideToggle();
    }
    

    function drawScoreCard(team_id, data){
    	$.each(data, function( index, scoreData ) {
		  	$("#sc_" + scoreData.hole + "_" + team_id).find(".col-hole").html("#" + scoreData.hole);
		  	$("#sc_" + scoreData.hole + "_" + team_id).find(".box-inner").html(scoreData.score);
		  	$("#sc_" + scoreData.hole + "_" + team_id).find(".col-par").html(scoreData.par);

		  	if(parseInt(scoreData.score) == (parseInt(scoreData.par) -2)){
		  		// console.log("eagle");
		  		$("#sc_" + scoreData.hole + "_" + team_id).find(".box-outer").addClass("circle-border");
		  		$("#sc_" + scoreData.hole + "_" + team_id).find(".box-inner").addClass("circle-border");
		  	}
		  	else if(parseInt(scoreData.score) == (parseInt(scoreData.par) -1)){
		  		// console.log("birdy");
				$("#sc_" + scoreData.hole + "_" + team_id).find(".box-outer").addClass("circle-border");
		  	}
		  	else if(parseInt(scoreData.score) == (parseInt(scoreData.par) +1)){
		  		// console.log("bogey");
				$("#sc_" + scoreData.hole + "_" + team_id).find(".box-outer").addClass("square-border");
		  	}
		  	else if(parseInt(scoreData.score) == (parseInt(scoreData.par) +2)){
		  		// console.log("double");
				$("#sc_" + scoreData.hole + "_" + team_id).find(".box-outer").addClass("square-border")
				$("#sc_" + scoreData.hole + "_" + team_id).find(".box-inner").addClass("square-border");;
		  	}
		});
    }

// *********************************************
// ******************* MQTT ********************
// *********************************************
 
        var userID = '<?php echo $userID ?>';
        var userAvatar = '<?php echo $userAvatar ?>';
        var client = new Paho.MQTT.Client("mqtt2.apengage.io", Number(8083), "fc_client_" + userID);

        client.onConnectionLost = function (responseObject) {
            console.log("MQTT Connection Lost: " + responseObject.errorMessage);
			 connectMQTT();
        };

        client.onMessageArrived = function (message) {
            if(message.destinationName == "fc/notify/score"){

                if (localStorage.notifycount) {
                    localStorage.notifycount = Number(localStorage.notifycount) + 1;
                } else {
                    localStorage.notifycount = 1;
                }

                var count = localStorage.notifycount;
                localStorage.setItem(count, message.payloadString);
                $("#notify-count").html(count);

            }else if(message.destinationName.includes("fc/position/")){
                
				// console.log("Last Position..");
                // console.log(message.payloadString);

            }
        };

        function connectMQTT(){
            var options = {
                timeout: 3,
                cleanSession: false,
                userName: "apengage", 
		        password: "webpass",
		        useSSL: true,
                onSuccess: function () {
                    console.log("MQTT Connection Success!");
                    client.subscribe('fc/notify/score', { qos: 1 });
                    client.subscribe('fc/selfcheck/' + userID, { qos: 1 });
                    message = new Paho.MQTT.Message("getting old messages...");
                    message.destinationName = "fc/selfcheck/" + userID; 
                    client.send(message);
                },
                onFailure: function (message) {
                    console.log("MQTT Connection Failed: " + message.errorMessage);
					 connectMQTT();
                }
            };
            client.connect(options);
        }

        connectMQTT();
       
        // Try HTML5 geolocation.
        navigator.geolocation.watchPosition(
            function(position) {
                var lat = position.coords.latitude;
                var lon = position.coords.longitude;
                publishPosition(lat, lon);
            },
            function(error){
                console.log("geolocation watch error");
            },
            {
                maximumAge: 30000, 
                timeout: 60000, 
                enableHighAccuracy: true 
            }
        );

        function publishPosition(lat, lon){
	      	message = new Paho.MQTT.Message(lat + ',' + lon + ',' + userAvatar + ',' + myTeam);
          	message.destinationName = "fc/position/" + userID;
          	client.send(message);
        }

// *********************************************
// ******************* END ********************
// *********************************************



</script>

@endsection