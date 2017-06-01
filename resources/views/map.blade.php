@extends('layouts.master')

@section('scripts')
	

@endsection

@section('content')

<style>

#markerLayer img {
    border: 2px solid red !important;
    width: 85% !important;
    height: 90% !important;
    border-radius: 5px;
}

#map{
    position: absolute;
    height: 100%;
    width: 100%;
    margin-left: -10px !important;
}



</style>

  <div class="wrapper wrapper-content">
  		<div class="row">
  			<div id="map"></div>
  		</div> 
  </div>

    <?php $userID = Auth::user()->id; ?>
    <?php $userAvatar = Auth::user()->avatar; ?>
    <?php $myTeamName = Session::get('myteam')->name ?>

<script>
 	
 	var map;
    var playermarkers = {};

    var userID = '<?php echo $userID ?>';
    var myTeam = '<?php echo $myTeamName ?>';

    var dmcnt = 0;

    var mainMarker = null;
    var distMarker = null;
    var distLine = null;
    var infoWindow = null;
    var myPos = null;

    function initMap() {

        console.log("Start Loading Map");

        map = new google.maps.Map(document.getElementById('map'), {
            zoom: 18,
            center: new google.maps.LatLng(43.3898045900, -79.8109913600),
            mapTypeId: google.maps.MapTypeId.SATELLITE,
            zoomControl: false,
            mapTypeControl: false,
            scaleControl: true,
            streetViewControl: false,
            rotateControl: false,
            fullscreenControl: false
        });


        map.addListener('click', function(event) {
            setDistMarker(event.latLng);
        });

        // Try HTML5 geolocation.
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                var pos = {
                    lat: position.coords.latitude,
                    lng: position.coords.longitude
                };
                map.setCenter(pos);
                setMainMarker(pos);
                connectMQTT();

            });
        } else {
            alert("Browser does not support geolocation");
        }
    }



    function addMarkerUser(data, user_id){

        var parts = data.split(',');
        var LatLng = {
                lat: parseFloat(parts[0]), 
                lng: parseFloat(parts[1])
            };

        // if(userID != user_id){ 
            if (user_id in playermarkers){

                marker = playermarkers[user_id];
                marker.setPosition(LatLng);

            } else {

                //create player icon
                var icon = {
                    url: parts[2], // url
                    scaledSize: new google.maps.Size(60,60), // scaled size
                    origin: new google.maps.Point(0,0), // origin
                    anchor: new google.maps.Point(30,30), // anchor
                };

                // add player marker
                var marker = new google.maps.Marker({
                    position: LatLng,
                    animation: google.maps.Animation.DROP,
                    map: map,
                    title: parts[3],
                    icon: icon
                });
 
                // add player content window
                marker.info = new google.maps.InfoWindow({
                    content: '<img src="'+parts[2]+'" alt="team img" /><br>'+parts[3] 
                });

                google.maps.event.addListener(marker, 'click', function() {
                    marker.info.open(map, marker);
                });

                // add player to array;
                playermarkers[user_id] = marker;
                
            }
        // }
    }

    function drawDistance(){

        if(distLine != null){
            distLine.setMap(null);
        }

        var data = calculateDistance(mainMarker.position.lat(), mainMarker.position.lng(), distMarker.position.lat(), distMarker.position.lng());

        infoWindow.setContent('<b>Distance: </b><span style="font-size:18px;">' + data[0] + '</span> yds<br><b>Club:</b> <span style="font-size:14px;">' + data[1] +
            '</span><br>');

        // <a id="dm_' + dmcnt + '" class="info-window">Remove</a>

        distLine = new google.maps.Polyline({
            path: [
                new google.maps.LatLng(mainMarker.position.lat(), mainMarker.position.lng()), 
                new google.maps.LatLng(distMarker.position.lat(), distMarker.position.lng())
            ],
            strokeColor: "#FF0000",
            strokeOpacity: 0.4,
            strokeWeight: 3,
            map: map
        });

    }

    function setMainMarker(location){

       // check if distance maker is already set
        if(mainMarker != null){
            mainMarker.setMap(null);
        }

        var icon = {
            url: "images/main-marker.ico", // url
            scaledSize: new google.maps.Size(60, 60), // scaled size
            origin: new google.maps.Point(0,0), // origin
            anchor: new google.maps.Point(30, 60) // anchor
        };


        // create distance marker
        mainMarker = new google.maps.Marker({
            animation: google.maps.Animation.DROP,
            position: new google.maps.LatLng(location),
            draggable: true,
            map: map,
            icon: icon
        });

        // create drag listener
        google.maps.event.addListener(mainMarker, 'drag', function() {
            drawDistance();
        });

        
    }

    function setDistMarker(location){

        // check if distance maker is already set
        if(distMarker != null){
            distMarker.setMap(null);
            distLine.setMap(null);
        }

        var icon = {
            url: "images/dist-marker.png", // url
            scaledSize: new google.maps.Size(60, 60), // scaled size
            origin: new google.maps.Point(0,0), // origin
            anchor: new google.maps.Point(30, 60) // anchor
        };

        // create distance marker
        distMarker = new google.maps.Marker({
            animation: google.maps.Animation.DROP,
            position: location,
            draggable: true,
            map: map,
            icon: icon
        });

        infoWindow = new google.maps.InfoWindow({
            content: ''
        });
        
        drawDistance();

        // open info window
        infoWindow.open(map, distMarker);

        // add click listener
        google.maps.event.addListener(distMarker, 'click', function() {
            infoWindow.open(map, distMarker);
        });

        // create drag listener
        google.maps.event.addListener(distMarker, 'drag', function() {
            drawDistance();
        });

    }


    $("#map").on('click', '.info-window', function(e){
        e.preventDefault();
        distMarker.setMap(null);
        distLine.setMap(null);      
    });

    function calculateDistance(lat1,lon1,lat2,lon2) {
        var R = 6371; // Radius of the earth in km
        var dLat = deg2rad(lat2-lat1);  // deg2rad below
        var dLon = deg2rad(lon2-lon1); 
        var a = 
            Math.sin(dLat/2) * Math.sin(dLat/2) +
            Math.cos(deg2rad(lat1)) * Math.cos(deg2rad(lat2)) * 
            Math.sin(dLon/2) * Math.sin(dLon/2)
            ; 
        var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a)); 
        var km = R * c; // Distance in km
        var yd = Math.round(km/0.0009144);
        // $("#pin-val" + currentHole).html("<strong>" + yd + " yd</strong>");
        var club = getClub(yd);
        return [yd,club];
    }

    function deg2rad(deg) {
        return deg * (Math.PI/180)
    }

    Number.prototype.between = function (min, max) {
        return this > min && this < max;
    };

    function getClub(yd){
        var club = "";
        if((yd).between(210, 400)) {
            club = "Driver";
        } else if((yd).between(190, 210)){
            club = "3 Wood";
        } else if((yd).between(180, 190)){
            club = "2 Iron";
        } else if((yd).between(170, 180)){
            club = "3 Iron";
        }else if((yd).between(160, 170)){
            club = "4 Iron";
        }else if((yd).between(150, 160)){
            club = "5 Iron";
        }else if((yd).between(140, 150)){
            club = "6 Iron";
        }else if((yd).between(130, 140)){
            club = "7 Iron";
        }else if((yd).between(120, 130)){
            club = "8 Iron";
        }else if((yd).between(80, 120)){
            club = "9 Iron";
        }else if((yd).between(40, 80)){
            club = "Pitching Wedge";
        }else if((yd).between(30, 40)){
            club = "Sand Wedge";
        }else if((yd).between(20, 30)){
            club = "Lob Wedge";
        }else if((yd).between(1, 20)){
            club = "Putter";
        } else {
            club = "To Far";
            // console.log("OUT OF RANGE");
        }
        return club;
        // $("#club" + currentHole).html("<strong>" + club + "</strong>");
    }
// *********************************************
// ******************* MQTT ********************
// *********************************************

        var userID = '<?php echo $userID ?>';
        var userAvatar = '<?php echo $userAvatar ?>';
        var wsbroker = "mqtt.apengage.io";
        var wsport = 9001;
        var client = new Paho.MQTT.Client(wsbroker, wsport, "fc_client_" + userID);

        client.onConnectionLost = function (responseObject) {
            console.log("MQTT Connection Lost: " + responseObject.errorMessage);
            connectMQTT();
        };

        client.onMessageArrived = function (message) {
            // console.log("Topic: " + message.destinationName);
            // console.log("Message: " + message.payloadString);
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
                
                // console.log(message.payloadString);
                items = message.destinationName.split('/');
                addMarkerUser(message.payloadString, items[2]);

            }
        };

        function connectMQTT(){
            console.log("Attempting MQTT connection...");
            var options = {
                timeout: 3,
                cleanSession: false,
                userName: 'apengage',
                password: 'webpass',
                onSuccess: function () {
                    console.log("MQTT Connection Success!");
                    client.subscribe('fc/notify/score', { qos: 1 });
                    client.subscribe('fc/selfcheck/' + userID, { qos: 1 });
                    client.subscribe('fc/position/#', { qos: 1 });
                    message = new Paho.MQTT.Message("this gets old messages");
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

        
        
       
        // Try HTML5 geolocation.
        navigator.geolocation.watchPosition(
            function(position) {
                var lat = position.coords.latitude;
                var lon = position.coords.longitude;
                // var tempLat = "43.39095";
                // var tempLon = "-79.81103361";  
                // publishPosition(tempLat, tempLon);
                publishPosition(lat, lon);
                mypos = { lat: position.coords.latitude, lng: position.coords.longitude };
            },
            function(error){
                console.log("geolocation watch error");
            },
            {
                maximumAge: 10000, 
                timeout: 30000, 
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

<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDwYvEiJHi4rgFoTUb9i1Eexeds7ssfzew&callback=initMap"></script>

@endsection