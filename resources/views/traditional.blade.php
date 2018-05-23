@extends('layouts.master')


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
  		
  		@if($tournament->id == 1)
  			<div class="col-xs-6 animated fadeInDown">
  				<h3>{{ $tournament->name }}</h3>
  			</div>
<!--   			<div class="col-xs-6 align-right animated fadeInDown" style="padding-top: 4px;">
  				<a href="/standings" class=""> Back to Live <i class="fa fa-forward"></i></a>
  			</div> -->
  		@else
			<div class="col-xs-6 animated fadeInDown">
  				<h3>{{ $tournament->name }}</h3>
  			</div>
<!--   			<div class="col-xs-6 align-right animated fadeInDown" style="padding-top: 4px;">
  				<a href="/lastyear" class=""> View Last Year <i class="fa fa-backward"></i></a>
  			</div> -->
  		@endif
  		<br/>
  		<br/>
  		<div class="col-md-6 col-lg-8">
	  		<div class="ibox float-e-margins">
	            <div class="ibox-content">
	            <div class="row standings-header">
	            	<div class="col-xs-2" style="padding-left:5px;"><strong>Rank</strong></div>
	            	<div class="col-xs-8" style="padding-left:5px;"><strong>Team</strong></div>
	            	<div class="col-xs-2" style="padding-left:5px;"><strong>Score</strong></div>
            	</div>
				@if(!empty($standings))	
                    @foreach ($standings as $standing)
		                <div class="row standings-row" onclick="getScoreCard('{{ $standing->id_team }}');"> 
		                	<div class="row">
			                    <div class="col-xs-2 rank-col">
			                    	@if($standing->rank == 1)
			                    		{{ $standing->rank }}<sup class="rank-sup">st</sup>
			                    	@elseif($standing->rank == 2)
			                    		{{ $standing->rank }}<sup class="rank-sup">nd</sup>
			                    	@elseif($standing->rank == 3)
			                    		{{ $standing->rank }}<sup class="rank-sup">rd</sup>
			                    	@else($standing->rank > 3)
			                    		{{ $standing->rank }}<sup class="rank-sup">th</sup>
			                    	@endif
			                    </div>
			                    <div class="col-xs-8 name-col">
			                    	@if(!empty($standing->user1_avatar))
			                    		<img class="avatar" src="{{ $standing->user1_avatar }}" height="30" width="30" /> 
			                    	@elseif(!empty($standing->user1_avatar))
			                    		<img class="avatar" src="{{ $standing->user2_avatar }}" height="30" width="30" /> 
			                    	@else 
			                    		<img class="avatar" src="images/empty_user.jpg" height="30" width="30" />
			                    	@endif 
			                    	&nbsp{{ $standing->TeamName }}
			                    </div>
			                    <div class="col-xs-2 score-col"> 
			                    	@if($standing->score < 0)
			                    		<i class="fa fa-level-down green-text"></i>&nbsp{{ $standing->score }}
			                    	@elseif($standing->score > 0)
			                    		<i class="fa fa-level-up red-text"></i>&nbsp+{{ $standing->score }}
			                    	@else($standing->score == 0)
			                    		<i class="fa fa-minus"></i>&nbspE
			                    	@endif
			                    </div>
			                </div>
		                    <input type="hidden" id="hidden_set{{ $standing->id_team }}" value="0" />	   
		                    <div class="row" id="score{{ $standing->id_team }}" style="display:none; text-align:center;">
		                    	<br />
		                		<div class="col-xs-6"><strong>Front 9</strong>
		                			<div class="row">
		                				<div class="col-xs-4"><small><strong>Hole</strong></small></div>
				                		<div class="col-xs-4"><small><strong>Score</strong></small></div>
				                		<div class="col-xs-4"><small><strong>Par</strong></small></div>
				                	</div>
				                	<div class="row" id="sc_1_{{ $standing->id_team }}">
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
				                	<div class="row" id="sc_2_{{ $standing->id_team }}">
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
				                	<div class="row" id="sc_3_{{ $standing->id_team }}">
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
				                	<div class="row" id="sc_4_{{ $standing->id_team }}">
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
				                	<div class="row" id="sc_5_{{ $standing->id_team }}">
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
				                	<div class="row" id="sc_6_{{ $standing->id_team }}">
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
				                	<div class="row" id="sc_7_{{ $standing->id_team }}">
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
				                	<div class="row" id="sc_8_{{ $standing->id_team }}">
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
				                	<div class="row" id="sc_9_{{ $standing->id_team }}">
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
				                	<div class="row" id="sc_10_{{ $standing->id_team }}">
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
				                	<div class="row" id="sc_11_{{ $standing->id_team }}">
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
				                	<div class="row" id="sc_12_{{ $standing->id_team }}">
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
				                	<div class="row" id="sc_13_{{ $standing->id_team }}">
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
				                	<div class="row" id="sc_14_{{ $standing->id_team }}">
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
				                	<div class="row" id="sc_15_{{ $standing->id_team }}">
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
				                	<div class="row" id="sc_16_{{ $standing->id_team }}">
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
				                	<div class="row" id="sc_17_{{ $standing->id_team }}">
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
				                	<div class="row" id="sc_18_{{ $standing->id_team }}">
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
		                		<br />
		                		<div class="col-xs-12"><strong>Members:</strong>
		                			<div id="sc_members_{{ $standing->id_team }}">
		                			</div>
		                		</div>
		               		</div>
		            	</div>
		            @endforeach
					@endif
	            </div>
	        </div>
	    </div>

	    

	</div>
</div>

    <?php $userID = Auth::user()->id; ?>
    <?php $userAvatar = Auth::user()->avatar; ?>
 	<?php $myTeam = Session::get('myteam')->name ?>



@endsection


@section('scripts')
	

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
    	$.each(data.scores, function(index, scoreData) {
		  	$("#sc_" + scoreData.hole + "_" + team_id).find(".col-hole").html("#"+scoreData.hole);
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
		$.each(data.members, function(index, member) {
			var delim = "<span class=\"green-text\"><b> | </b></span>";
			if(index == (data.members.length - 1)){
				delim = "";
			}
			$("#sc_members_"+team_id).append("<span>"+member.name+"<span>" + delim);
		});
    }


// *********************************************
// ******************* MQTT ********************
// *********************************************
 
        var userID = '<?php echo $userID ?>';
        var userAvatar = '<?php echo $userAvatar ?>';
   var client = new Paho.MQTT.Client("test.mosquitto.org", Number(8081), "fc_client_" + userID);

        client.onConnectionLost = function (responseObject) {
            console.log("MQTT Connection Lost: " + responseObject.errorMessage);
			setTimeout(function(){
				connectMQTT();
			},1000);
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
                timeout: 20,
                cleanSession: false,
		        useSSL: true,
                onSuccess: function () {
                    console.log("MQTT Connection Success!");
                    client.subscribe('fc/notify/score', { qos: 0 });
                },
                onFailure: function (message) {
                    console.log("MQTT Connection Failed: " + message.errorMessage);
					setTimeout(function(){
						connectMQTT();
					},2000);
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
                enableHighAccuracy: false 
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