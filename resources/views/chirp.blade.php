@extends('layouts.master')

@section('content')
<style>

</style>

<div class="wrapper wrapper-content animated fadeInDown" style="margin-left: 5px !important;">
	<br/>

    <div class="row">
	    <div class="ibox float-e-margins">

	    <div class="col-xs-12" style="text-align: center;">
	    	<h2><i class="fa fa-comment"></i> <i>Send a <span class="green-text"><b>Chirp!</b></span></i><br></h2>
	    	<p>Select a team and write a small message. It will pop-up on there screen</p><br>
	    </div>

	   </div>
	</div>

    <div class="row">
	    <div class="ibox float-e-margins">
	    	
	        <div class="ibox-content">

                {{ Form::select('team', $allteams, null, ['class' => 'form-control', 'placeholder' => 'Select a team to chirp...']) }}

            </div>
	    </div>
    </div>

    <div class="row">
        <div class="ibox float-e-margins">
            <div class="ibox-content">

                <div class="">
                    <div class="feed-element">
                        <a href="profile.html" class="pull-left">
                            <img alt="image" class="img-circle" src="{{ asset(Auth::user()->avatar) }}">
                        </a>
                        <div class="media-body" style="font-size:16px;">
                            <strong>{{ htmlspecialchars($myteam->name) }}</strong><br>
                            <p><a class="text-info" href="#">@<span id="teamname">Team Name</span></a> <span id="text"> Your swing is weak, step your game up</span></p>
                        </div>
                    </div>
                </div>


                <div class="col-sm-12">
                    <div class="input-group">
                    	<input id="chirp" type="text" class="form-control" placeholder="Enter message...">
                    	<span class="input-group-btn">
                    		<button type="button" onclick="sendChirp()" class="btn btn-primary">Send!</button>
                    	</span>
                    </div>
                </div>

            </div>
        </div>
    </div>



</div>


@endsection

@section('scripts')

<script>

	var myTeamName = '{{ htmlspecialchars($myteam->name) }}';
	var myTeamID = '{{ $myteam->id }}';
    var userID = '{{ Auth::user()->id }}';
    var userAvatar = '{{ Auth::user()->avatar }}';
    var selectedName = '';
    var selectedID = '';

	$("#chirp").bind("keyup change", function(e) {
	    $("#text").html($(this).val());
	});

	$('select').on('change', function (e) {
		selectedName = $(this).find("option:selected").text();
		selectedID = $(this).find("option:selected").val();
	    $("#teamname").html(selectedName);
	});


    function sendChirp(){

    	var message = $("#chirp").val();
    	
    	if(selectedName == ''){
    		swal("Hold Up..","You need to select a team to chirp first, try again","error");
    	}else if(message == ''){
    		swal("Hold Up..","You need to write a chirp to send first, try again","error");
    	}else{

	    	var html = '<div class="row"><div class="col-xs-12">'+
		                    '<div class="feed-element">'+
		                        '<a href="profile.html" class="pull-left">'+
		                            '<img alt="image" class="img-circle" src="{{ asset(Auth::user()->avatar) }}">'+
		                        '</a>'+
		                        '<div class="media-body" style="font-size:16px;">'+
		                            '<strong>'+myTeamName+'</strong><br>'+
		                            '<p><a class="text-info" href="#">@'+selectedName+'</a> '+message+'</p>'+
		                        '</div>'+
		                    '</div>'+
		                '</div></div>';


	    	var time = moment().format();
	    	var notification = html + '|' + time;
	      	var message1 = new Paho.MQTT.Message(notification);
	      	message1.destinationName = "fc/notify/score";
	      	client.send(message1);


			var popup = selectedID+','+myTeamName+','+message+','+userAvatar;
	      	var message2 = new Paho.MQTT.Message(popup);
	      	message2.destinationName = "fc/notify/chirp";
	      	client.send(message2);


	      	saveNotification(html);

	      	setTimeout(function(){
	      		swal("Chirp delivered..","You can see it in the notification feed as well","success");
	      	},500);

	    }

    }



    function saveNotification(text){

		$.ajax({
		    url: 'insertNote',
		    type: "post",
		    dataType: "json",
		    data: {'text': text, 'team_id': myTeamID },
		    success: function(data){
				console.log("Notification Saved");
		    },
		    error: function(error){
		    	console.log(error);
		    }
		}); 

    }





// *********************************************
// ******************* MQTT ********************
// *********************************************


    var client = new Paho.MQTT.Client("test.mosquitto.org", Number(8081), "fc_client_" + userID);
    var maxAttempts = 0;

    client.onConnectionLost = function (responseObject) {
        console.log("MQTT Connection Lost: " + responseObject.errorMessage);
		setTimeout(function(){
            if(maxAttempts < 5){
				connectMQTT();
                maxAttempts++;
            }
		},2000);
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

        }else if(message.destinationName == "fc/notify/chirp"){

            var data = message.payloadString.split(',');
            if(data[0] == myTeamID){
                swal({
                    title: data[1], 
                    text: data[2], 
                    imageUrl: data[3],
                    confirmButtonText: "Close",
                });
            }

        }
    };

    function connectMQTT(){
    	console.log("Attempting MQTT connection...")
        var options = {
        	timeout: 20,
            cleanSession: false,
            useSSL: true,
            onSuccess: function () {
                console.log("MQTT Connection Success!");
                client.subscribe('fc/notify/score', { qos: 1 });
                client.subscribe('fc/notify/chirp', { qos: 1 });
                getLocation();
            },
            onFailure: function (message) {
                console.log("MQTT Connection Failed: " + message.errorMessage);
				setTimeout(function(){
					if(maxAttempts < 5){
                        connectMQTT();
                        maxAttempts++;
                    }
				},2000);
            }
        };
        client.connect(options);
    }
   

	function getLocation(){

		if(navigator.geolocation)
		{
			navigator.geolocation.watchPosition(
				function(position) {
					var myLat = position.coords.latitude;
					var myLon = position.coords.longitude;
					publishPosition(myLat, myLon);
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
		} 
		else 
		{
			alert("Geolocation is not supported by this browser.");
		}
	}

    function publishPosition(lat, lon){
      	message = new Paho.MQTT.Message(lat + ',' + lon + ',' + userAvatar + ',' + myTeamName);
      	message.destinationName = "fc/position/" + userID;
      	client.send(message);
    }


    connectMQTT();

// *********************************************
// ******************* END ********************
// *********************************************





</script>

@endsection