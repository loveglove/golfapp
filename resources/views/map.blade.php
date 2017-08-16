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

/*img{
    border-radius:50%;
    border:2px solid white;
}
*/

.customMarker {
    position:absolute;
    cursor:pointer;
    background:#424242;
    width:100px;
    height:100px;
    /* -width/2 */
    margin-left:-50px;
    /* -height + arrow */
    margin-top:-110px;
    border-radius:10px;
    padding:0px;
}
.customMarker:after {
    content:"";
    position: absolute;
    bottom: -10px;
    left: 40px;
    border-width: 10px 10px 0;
    border-style: solid;
    border-color: #424242 transparent;
    display: block;
    width: 0;
}
.customMarker img {
    width:90px;
    height:90px;
    margin:5px;
    border-radius:10px;
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
    var curvature = 0.5;
    var Point = null;

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
            if(user_id in playermarkers){

                marker = playermarkers[user_id];
                marker.setPosition(LatLng);

            }else{

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

                //adapted from http://gmaps-samples-v3.googlecode.com/svn/trunk/overlayview/custommarker.html
                // function CustomMarker(latlng, map, imageSrc) {
                //     this.latlng_ = latlng;
                //     this.imageSrc = imageSrc;
                //     // Once the LatLng and text are set, add the overlay to the map.  This will
                //     // trigger a call to panes_changed which should in turn call draw.
                //     this.setMap(map);
                // }

                // CustomMarker.prototype = new google.maps.OverlayView();

                // CustomMarker.prototype.draw = function () {
                //     // Check if the div has been created.
                //     var div = this.div_;
                //     if (!div) {
                //         // Create a overlay text DIV
                //         div = this.div_ = document.createElement('div');
                //         // Create the DIV representing our CustomMarker
                //         div.className = "customMarker"


                //         var img = document.createElement("img");
                //         img.src = this.imageSrc;
                //         div.appendChild(img);
                //         google.maps.event.addDomListener(div, "click", function (event) {
                //             google.maps.event.trigger(me, "click");
                //         });

                //         // Then add the overlay to the DOM
                //         var panes = this.getPanes();
                //         panes.overlayImage.appendChild(div);
                //     }

                //     // Position the overlay 
                //     var point = this.getProjection().fromLatLngToDivPixel(this.latlng_);
                //     if (point) {
                //         div.style.left = point.x + 'px';
                //         div.style.top = point.y + 'px';
                //     }
                // };

                // CustomMarker.prototype.remove = function () {
                //     // Check if the overlay was on the map and needs to be removed.
                //     if (this.div_) {
                //         this.div_.parentNode.removeChild(this.div_);
                //         this.div_ = null;
                //     }
                // };

                // CustomMarker.prototype.getPosition = function () {
                //     return this.latlng_;
                // };

                // new CustomMarker(LatLng, map, parts[2]);
                
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

        distLine = new google.maps.Polyline({
            path:[
                new google.maps.LatLng(mainMarker.position.lat(), mainMarker.position.lng()),
                new google.maps.LatLng(distMarker.position.lat(), distMarker.position.lng())
            ],
            strokeColor: "#FF0000",
            strokeOpacity: 0.3,
            strokeWeight: 4,
            map: map
        });

        // <a id="dm_' + dmcnt + '" class="info-window">Remove</a>

        // Point = google.maps.Point;

        // var pos1 = new google.maps.LatLng(mainMarker.position.lat(), mainMarker.position.lng()), // latlng
        //     pos2 = new google.maps.LatLng(distMarker.position.lat(), distMarker.position.lng())
        //     projection = map.getProjection(),
        //     p1 = projection.fromLatLngToPoint(pos1), // xy
        //     p2 = projection.fromLatLngToPoint(pos2);

        // // Calculate the arc.
        // // To simplify the math, these points 
        // // are all relative to p1:
        // var e = new Point(p2.x - p1.x, p2.y - p1.y), // endpoint (p2 relative to p1)
        //     m = new Point(e.x / 2, e.y / 2), // midpoint
        //     o = new Point(e.y, -e.x), // orthogonal
        //     c = new Point( // curve control point
        //         m.x + curvature * o.x,
        //         m.y + curvature * o.y);

        // var pathDef = 'M 0,0 ' +
        //     'q ' + c.x + ',' + c.y + ' ' + e.x + ',' + e.y;

        // var zoom = map.getZoom(),
        //     scale = 1 / (Math.pow(2, -zoom));

        // var symbol = {
        //     path: pathDef,
        //     scale: scale,
        //     strokeColor: "#FF0000",
        //     strokeOpacity: 0.3,
        //     strokeWeight: 4,
        //     fillColor: 'none'
        // };

        // if (!distLine) {
        //     distLine = new google.maps.Marker({
        //         position: pos1,
        //         clickable: false,
        //         icon: symbol,
        //         zIndex: 0, // behind the other markers
        //         map: map
        //     });
        // } else {
        //     distLine.setOptions({
        //         position: pos1,
        //         icon: symbol,
        //     });
        // }


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
        if((yd).between(250, 400)) {
            club = "Driver";
        } else if((yd).between(195, 250)){
            club = "3 Wood";
        } else if((yd).between(185, 195)){
            club = "2 Iron";
        } else if((yd).between(175, 185)){
            club = "3 Iron";
        }else if((yd).between(165, 175)){
            club = "4 Iron";
        }else if((yd).between(155, 165)){
            club = "5 Iron";
        }else if((yd).between(145, 155)){
            club = "6 Iron";
        }else if((yd).between(135, 145)){
            club = "7 Iron";
        }else if((yd).between(125, 135)){
            club = "8 Iron";
        }else if((yd).between(80, 125)){
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
        var client = new Paho.MQTT.Client("mqtt.apengage.io", Number(8083), "/wss", "fc_client_" + userID);

        client.onConnectionLost = function (responseObject) {
            console.log("MQTT Connection Lost: " + responseObject.errorMessage);
            connectMQTT();
        };

        client.onMessageArrived = function (message) {
            // console.log("Topic: " + message.destinationName);
            // console.log("Message: " + message.payloadString);
            if(message.destinationName == "fc/notify/score"){

                if(localStorage.notifycount) {
                    localStorage.notifycount = Number(localStorage.notifycount) + 1;
                }else{
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
                timeout: 20,
                cleanSession: false,
                userName: 'apengage',
                password: 'webpass',
                useSSL: true,
                onSuccess: function () {
                    console.log("MQTT Connection Success!");
                    client.subscribe('fc/notify/score', { qos: 1 });
                    // client.subscribe('fc/selfcheck/' + userID, { qos: 1 });
                    client.subscribe('fc/position/#', { qos: 1 });
                    // message = new Paho.MQTT.Message("this gets old messages");
                    // message.destinationName = "fc/selfcheck/" + userID; 
                    // client.send(message);
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