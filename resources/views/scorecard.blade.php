@extends('layouts.master')


@section('content')


  <div class="wrapper wrapper-content animated fadeInDown">
  		<br/>
        <div class="row main-row">
            <div id="contain" class="col-sm-12 col-md-6 col-lg-4">
				@foreach ($course as $hole)
					<a id="anchor{{  $hole->hole }}"></a>
                    <div class="ibox float-e-margins">
                        <div class="ibox-content">
		                	<div class="row">
                                <div class="col-xs-6" style="text-align: center; padding-top: 5px;">
                                	<div class="row">
								        <div class="col-xs-6" style="padding-right:2px;">
									        <div class="hole-info blue-bg" style="width:100%;">
							                   <strong>Hole</strong>
							                   <br/>
							                   <span style="font-size:20px;"><strong>#{{ $hole->hole }}</strong></span>
									        </div> 
									    </div>
									    <div class="col-xs-6" style="padding-left:2px;" >   
									        <div class="hole-info beige-bg">
							                   <strong>Par</strong>
							                    <br />
							                	<span style="font-size:20px;"><strong><strong>{{ $hole->par }}</strong></span>
									        </div> 
									     </div>
								    </div>
<!-- 							         <div class="hole-info blue-bg" >
							            <div class="row">
							                <div class="col-xs-4 text-left">
							                   <strong>Blue</strong>
							                </div>
							                <div class="col-xs-8 text-right">
							                    <strong>{{ $hole->blue }} yd</strong>
							                </div>
							            </div>
							        </div>   -->
							        <div class="hole-info white-bg">
							            <div class="row">
							                <div class="col-xs-4 text-left">
							                   <strong>White</strong>
							                </div>
							                <div class="col-xs-8 text-right">
							                    <strong>{{ $hole->white }} yd</strong>
							                </div>
							            </div>
							        </div> 
                                    <div class="hole-info red-bg">
                                        <div class="row">
                                            <div class="col-xs-4 text-left">
                                               <strong>Red</strong>
                                            </div>
                                            <div class="col-xs-8 text-right">
                                                <strong>{{ $hole->red }} yd</strong>
                                            </div>
                                        </div>
                                    </div> 
							        <div class="hole-info green-bg">
							            <div class="row">
							                <div class="col-xs-4 text-left">
							                   <strong>Pin</strong>
							                </div>
							                <div id="pin-val{{ $hole->hole }}" class="col-xs-8 text-right">
							                    <strong>-</strong>
							                </div>
							            </div>
							        </div>     
									<div class="hole-info silver-bg">
							            <div class="row">
							                <div class="col-xs-4 text-left">
							                   <strong>Club</strong>
							                </div>
							                <div id="club{{ $hole->hole }}" class="col-xs-8 text-right">
							                    <strong>-</strong>
							                </div>
							            </div>
							        </div>                                         
                                </div>
						        <div class="col-xs-6" style="text-align: center;">
								@if(!empty($hole->image))
						        	<a onclick="openImageModal('{{ $hole->image }}','{{ $hole->hole }}');">
						        		<img src="{{ $hole->image }}" class="holeimage-sm" alt="hole image" />
						        	</a>
								@else
									<div style="display: table; height: 240px; overflow: hidden;">
										<div style="display: table-cell; vertical-align: middle;">
											<div>
												<h3> No Hole Image Available </h3>
											</div>
										</div>
									</div>
								@endif
						        </div>
						    </div>
						    <input type ="hidden" id="pinLat{{ $hole->hole }}" value="{{ $hole->pin_lat }}" />
						    <input type ="hidden" id="pinLon{{ $hole->hole }}" value="{{ $hole->pin_lon }}" />
		                    <div class="row">
		                    	<input type ="hidden" id="hdnpar{{ $hole->hole }}" value="{{ $hole->par }}" />
		                    	<div class="knob-container">
		                    		<input id="{{ $hole->hole }}" type="text" value="0" class="knobclass dial m-r"
		                    		data-thickness="0.5" 
		                    		data-fgColor="#62BE5C" 
		                    		data-width="180" 
		                    		data-height="140" 
		                    		data-angleOffset=-125 
		                    		data-angleArc=250
		                    		data-step="1"
									data-min="0"
									data-max="10"
									data-readOnly="false"
									/>
		                    	</div>
		                    	<div style="text-align:center;">
		                    		<h4 id="value-text{{ $hole->hole }}">-</h4>
		                    		<input id="value-int{{ $hole->hole }}" type="hidden" />
		                    	</div>
		                    </div>
                        </div>		
                    </div>
                @endforeach
            </div>
        </div>

		<div class="modal fade" id="holePreview" role="dialog" aria-hidden="true" style="z-index:99999;">
		  <div class="modal-dialog">
		    <div class="modal-content">  
		        <div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><h3><i class="fa fa-times fa-lg"></i></h3></button>
					<h3 id="hole-modal-title"></h3>
				</div>            
		      	<div class="modal-body" style="text-align: center;">
					<img src="" id="holeimage-lg" alt="hole image" />
		      	</div>
		    </div>
		  </div>
		</div>
	</div>


@endsection
	  
@section('scripts')
<!-- JSKnob -->
<script src="{{ asset('/theme/js/plugins/jsKnob/jquery.knob.js') }}"></script>
<script>

	var teamName = "{{ htmlspecialchars($team->name) }}";
	var teamID = "{{ $team->id }}";
    var userID = "{{ Auth::user()->id }}";
    var userAvatar = "{{ Auth::user()->avatar }}";

	var starthole = "{{ $team->start }}";
	var currentHole = null;


	function openImageModal(imgPath, hole){
		$("#holeimage-lg").attr("src",imgPath);
		$("#hole-modal-title").html("Hole #" + hole);
		$("#holePreview").modal("show");
	}

    $(document).ready(function() {


      	$(".dial").knob({
    		'release' : function (val) { 
    			var hole = this.$.attr('id');
    			var par = $("#hdnpar" + hole).val();
                setTimeout(function(){
                    confirmSave(val, hole, par);
                }, 200);
    		}
		});

		$('.dial').trigger('configure', {
		    'draw': function (v) {
				var hole = this.$.attr('id');
				var par = parseInt($("#hdnpar" + hole).val());
	          	v = parseInt(document.getElementById(hole).value);
	          	
	          	if(v == 0){
		            this.o.fgColor='#62BE5C';
		            $("#" + hole).css("color", "white");
		            $("#value-text" + hole).html("touch and slide to enter score");
		            $("#value-int" + hole).val("");
	          	}
				else if(v == 1) {
	          		this.o.fgColor='#33cccc';
		            $("#" + hole).css("color", "#33cccc");
		            $("#value-text" + hole).html("Hole In One");
	            	$("#value-int" + hole).val(-4);
	        	}
	          	else if(v == (par - 3) && !((par - 3) == 1)) {
	          		this.o.fgColor='#33cccc';
		            $("#" + hole).css("color", "#33cccc");
		            $("#value-text" + hole).html("Albatross");
	            	$("#value-int" + hole).val(-3);
	        	}
		        else if(v == (par - 2) && !((par - 2) == 1)) {
		            this.o.fgColor='#62BE5C';
		            $("#" + hole).css("color", "#62BE5C");
		            $("#value-text" + hole).html("Eagle");
		             $("#value-int" + hole).val(-2);
		        }
		        else if(v == (par - 1)) {
		            this.o.fgColor='#62BE5C';
		            $("#" + hole).css("color", "#62BE5C");
		            $("#value-text" + hole).html("Birdie");
		            $("#value-int" + hole).val(-1);
		        }
		        else if(v == par) {
		            this.o.fgColor='#89C558';
		            $("#" + hole).css("color", "#89C558");
		            $("#value-text" + hole).html("Par");
		            $("#value-int" + hole).val(0);
		        }
		        else if(v == (par + 1)){
		            this.o.fgColor='#B9CC54';
		            $("#" + hole).css("color", "#B9CC54");
		            $("#value-text" + hole).html("Bogey");
		            $("#value-int" + hole).val(1);
		        }
		        else if(v == (par + 2)){
		            this.o.fgColor='#D4B64F';
		            $("#" + hole).css("color", "#D4B64F");
		             $("#value-text" + hole).html("Double Bogey");
		             $("#value-int" + hole).val(2);
		        }
		        else if(v == (par + 3)) {
		            this.o.fgColor='#DB824A';
		            $("#" + hole).css("color", "#DB824A");
		            $("#value-text" + hole).html("Bollox");
		            $("#value-int" + hole).val(3);
		        }
		        else if(v >= (par + 4)) {
		            this.o.fgColor='#E34444';
		            $("#" + hole).css("color", "#E34444");
		            $("#value-text" + hole).html("Bollox!!!");
		            $("#value-int" + hole).val(4);
		        }
		    }
		});
		$('.dial').trigger('change');

      	var completed = <?php echo json_encode($completed) ?>;
      	$.each(completed, function(index, item){
      		currentHole = parseInt(item["hole"]) + 1;
            if(currentHole == 19){
                currentHole = 1;
            }
      		$("#" + item["hole"]).val(item["score"]);
      		var hole = item["hole"];
      		var par = parseInt($("#hdnpar" + hole).val());
			var v = parseInt(item["score"]);
  			if(v == 0){
	            $("#value-text" + hole).html("-");
	            $("#value-int" + hole).val("-");
          	}
			else if(v == 1) {
	            $("#value-text" + hole).html("Hole In One");
	            $("#value-int" + hole).val(-4);
	        }
          	else if(v == (par - 3) && !((par - 3) == 1)) {
	            $("#value-text" + hole).html("Albatross");
	            $("#value-int" + hole).val(-3);
	        }
	        else if(v == (par - 2) && !((par - 2) == 1)) {
	            $("#value-text" + hole).html("Eagle");
	            $("#value-int" + hole).val(-2);
	        }
	        else if(v == (par - 1)) {
	            $("#value-text" + hole).html("Birdie");
	            $("#value-int" + hole).val(-1);
	        }
	        else if(v == par) {
	            $("#value-text" + hole).html("Par");
	            $("#value-int" + hole).val(0);
	        }
	        else if(v == (par + 1)){
	            $("#value-text" + hole).html("Bogey");
	            $("#value-int" + hole).val(1);
	        }
	        else if(v == (par + 2)){
	            $("#value-text" + hole).html("Double Bogey");
	            $("#value-int" + hole).val(2);
	        }
	        else if(v == (par + 3)) {
	            $("#value-text" + hole).html("Bollox");
	            $("#value-int" + hole).val(3);
	        }
	         else if(v >= (par + 4)) {
	            $("#value-text" + hole).html("Bollox!!!");
	            $("#value-int" + hole).val(4);
	        }
      		disableControl(item["hole"]);
      	});

		// alert(currentHole);

			if(currentHole > 0){
			    var anchor = $("#anchor" + currentHole);
	    		var position = anchor.position().top + $("body").scrollTop() +20;
	    		$("body").animate({scrollTop: position});
    		}

			// $("body").scrollTop($("#anchor" + currentHole).offset().top); 
            // $("#anchor" + currentHole).animate({ scrollTop: 0 }, "fast");

		console.log("current hole: " + currentHole);
		console.log("offest: " + position);


        if(currentHole === null && currentHole > 0){
    		currentHole = starthole;
    		var anchor = $("#anchor" + currentHole);
    		var position = anchor.position().top + $("body").scrollTop() +20;
    		$("body").animate({scrollTop: position});
        }

        connectMQTT();

    	if('{{ $team->members }}' == ""){
    		setTeamNames();	
    	}
      	
	});



	function setTeamNames(){

		swal({
		  title: "Who's on your team?",
		  text: "Please enter your team members names",
		  type: "input",
		  showCancelButton: false,
		  closeOnConfirm: false,
		  allowOutsideClick: false,
		  animation: "slide-from-top",
		  imageUrl: 'images/names-icon2.png',
		  inputPlaceholder: "Enter your names"
		},
		function(inputValue){

			if (inputValue === false) return false;

			if (inputValue === "") {
			    swal.showInputError("You need to write something!");
			    return false
			}

			$.ajax({
			    url: '/team/members',
			    type: "post",
			    dataType: "json",
			    data: {'name':inputValue, 'id': teamID },
			    success: function(data){
			    	console.log(data);
					swal("Nice!", "Your all set " + inputValue + "..", "success");	

			    },
			    error: function(error){
					console.log(error);
			    	swal("Oops..","Something went wrong while trying to save your name, please try again","error");
			    }
			});  
		});
	}


    function confirmSave(score, hole, par){

		// if(parseInt(hole) == currentHole || currentHole == 0){

			if(parseInt(score) != 0){
				swal({
					title: "Confirm Score",
					text: "Lock in your score of<font size='5'><strong>&nbsp" + score + "&nbsp</strong></font>for this hole?",
					showCancelButton: true,
					confirmButtonColor: "#62BE5C",
					confirmButtonText: "Yes",
					closeOnConfirm: false,
					imageUrl: "images/golfballdot.png",
					html: true
				},function(){
						saveScore(score, hole, par);
				});
			}
		// } else {
		// 	swal("Heads up!","Looks like you haven't submitted your score for the previous hole. Please do so before continuing","warning");
//              $("body").scrollTop($("#anchor" + currentHole).offset().top - 50); 
//              $("#" + hole).css("color", "white");
//              $("#value-text" + hole).html("touch and slide to enter score");
//              $("#value-int" + hole).val("-"); 
		// }
    }

    function saveScore(score, hole, par){

		$.ajax({
		    url: 'insertScore',
		    type: "post",
		    dataType: "json",
		    data: {'hole': hole, 'score':score, 'par':par },
		    success: function(data){

		    	swal({
		    		title: "Saved", 
		    		text: "Your score has been entered for hole #" + hole, 
		    		type: "success",
		    		timer: 3000
		    	});

				currentHole = parseInt(hole) + 1;
				if(currentHole == 19){
                    currentHole = 1;
                }

				console.log("current hole: " + currentHole);
				
		    	notify(score, hole, par);
		    	disableControl(hole);

                var cmp = $(".knobclass:disabled").length;
                console.log("Entered scores count: " + cmp);

                if(cmp == 18){
                    swal({
                        title: "Congratulations", 
                        text: "You have completed the tournament! You will be redirected to the standings shortly..", 
                        imageUrl: "images/trophy.png",
                    });
                    setTimeout(function(){
                        window.location = "standings";
                    },10000);
                }else{

				    var anchor = $("#anchor" + currentHole);
		    		var position = anchor.position().top + 20;
		    		$("body").animate({scrollTop: position});
		    		console.log(position);
	    		}

		    },
		    error: function(error){
		    	swal("Oops..","Something went wrong while attempting to save your score, please try again","error");
		    	console.log(error);
		    }
		});      
    }

    function saveNotification(text){

		$.ajax({
		    url: 'insertNote',
		    type: "post",
		    dataType: "json",
		    data: {'text': text, 'team_id': teamID },
		    success: function(data){
				console.log("Notification Saved");
		    },
		    error: function(error){
		    	console.log(error);
		    }
		});      
    }


    function disableControl(hole){
        $("#" + hole).siblings("canvas").remove();
		$("#" + hole).unwrap().attr("data-readOnly",true).attr("data-fgColor","gray").data("kontroled","").data("readonly",true).knob({'fgColor':'gray'});
		$("#" + hole).css("color", "gray").prop('disabled', true);
    }

    function notify(score, hole, par){
    	var hole_i = parseInt(hole);
    	var current = parseInt($("#value-int" + hole_i).val());
    	var back_1 = parseInt($("#value-int" + (hole_i - 1)).val());
    	var back_2 = parseInt($("#value-int" + (hole_i - 2)).val());
    	var back_3 = parseInt($("#value-int" + (hole_i - 3)).val());
    	var back_4 = parseInt($("#value-int" + (hole_i - 4)).val());

    	// is this an under par score?
    	if(current < 0){
			// Check for insane score
			if(current == -4){
				// console.log("albatross shot");
				publishMSG('fa-flag', teamName + " - <b>HOLE IN ONE</b><br/><b>Hole:</b> #" + hole);
			}else if(current == -3){
				// console.log("albatross shot");
				publishMSG('fa-star', teamName + " - <b>ALBATROSS</b><br/><b>Hole:</b> #" + hole);
			}
    		// check if there's a streak
    		else if(back_1 < 0 && back_2 < 0 && back_3 < 0 && back_4 < 0){
    			publishNote("{{ asset('images/heating.jpg') }}", '<strong>THERE HEATING UP!</strong><br/>'+ teamName +' are on fire. Catch up before they take it all!<br/><i>UnderPar Streak </i><span class="yel"><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i></span>');

    			// publishMSG('fa-smile-o', teamName + " are in there <b>Happy</b> place");
    		}else if (back_1 < 0 && back_2 < 0 && back_3 < 0){
    			// console.log("heavy streak");
    			publishNote("{{ asset('images/heating.jpg') }}", '<strong>THERE HEATING UP!</strong><br/>'+ teamName +' are on fire. Catch up before they take it all!<br/><i>UnderPar Streak </i><span class="yel"><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i></span>');
    		}else if (back_1 < 0 && back_2 < 0){
    			// console.log("hot streak");
    			publishNote("{{ asset('images/happy.jpg') }}", '<strong>JUST TAP IT IN</strong><br/>'+ teamName +' have found their <b>Happy Place</b>.<br/><i>UnderPar Streak </i><span class="yel"><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i></span>');
    		} else {
				if(current == -2){
					// console.log("eagle shot");
					publishNote("{{ asset('images/golfdance.gif') }}", '<strong>EAGLE SHOT</strong><br/>'+ teamName +' just eagled <b>Hole #'+ hole + '</b><br/><i>Beauty Hole </i><span class="yel"><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i></span>');
    			}
    			if(current == -1){
					// console.log("birdy shot");
					// publishMSG('fa-twitter', teamName + " just <b>birdied</b> hole #" + hole +);
					// publishNote('images/FTB.jpg','<strong>COACOWTB</strong><br/>Time to crack open a <b>Crispy Boy</b> and take it to pound town brochachos! <i>- '+teamName+'</i>' );
					publishNote("{{ asset('images/slowclap.gif') }}",'<strong>NICE BIRDIE</strong><br/>'+ teamName +' just birdied <b>Hole #'+ hole + '</b><br/><i>Great Hole </i><span style="color:aqua;"><i class="fa fa-twitter"></i></span>' );
    			}		
    		}

    	// is this a par score?
    	} else if (current == 0){
    		if(back_1 == 0 && back_2 == 0 && back_3 == 0 && back_4 == 0){
    			publishNote("{{ asset('images/caddyshack.gif') }}", '<strong>PAR PLAYERS</strong><br/>'+ teamName +' are playing textbook golf right now<br/><i>Par Streak </i><span class="green-text"><i class="fa fa-check"></i><i class="fa fa-check"></i><i class="fa fa-check"></i><i class="fa fa-check"></i></span>');
    		}else if (back_1 == 0 && back_2 == 0 && back_3 == 0){
    			publishNote("{{ asset('images/shooter.gif') }}", '<strong>SHOOTER</strong><br/>'+ teamName +' are putting on a free clinic!</b><br/><i>Par Streak </i><span class="green-text"><i class="fa fa-check"></i><i class="fa fa-check"></i><i class="fa fa-check"></i></span>');
    		}else if (back_1 == 0 && back_2 == 0){
				publishNote("{{ asset('images/nodedit.gif') }}", '<strong>NICE HOLE</strong><br/>'+ teamName +' are running even. Everybody keep up!</b><br/><i>Par Streak </i><span class="green-text"><i class="fa fa-check"></i><i class="fa fa-check"></i></span>');
    		} else {
    			// No streak
    			// Par shot. Do nothing
    		}

    	// is this an over score?
    	} else if (current > 0){
    		if(back_1 > 0 && back_2 > 0 && back_3 > 0 && back_4 > 0){
    			// console.log("should just give up");
    			publishNote("{{ asset('images/homer.gif') }}", '<strong>GAME OVER</strong><br/>'+ teamName +' are falling apart at the seams <br/><i>OverPar Streak </i><span class="redicon"><i class="fa fa-times"></i><i class="fa fa-times"></i><i class="fa fa-times"></i></span>');
    		}else if (back_1 > 0 && back_2 > 0 && back_3 > 0){
    			// console.log("shitting the bed");
    			publishNote("{{ asset('images/tigerwoods.jpg') }}", '<strong>ROUGH DAY</strong><br/>'+ teamName +' are struggling to stay in the game. <br/><i>OverPar Streak </i><span class="redicon"><i class="fa fa-times"></i><i class="fa fa-times"></i></span>');
    		}else if (back_1 > 0 && back_2 > 0){
    			// console.log("brutal go at it");
    			publishNote("{{ asset('images/baywatch.jpg') }}", '<strong>BEACH BUMS</strong><br/>'+ teamName +' are spending more time in the sand then David Hasselfoff<br/><i>OverPar Streak </i><span class="redicon"><i class="fa fa-times"></i></span>');
    		} else {
    			// No streak
    			if(current >= 3){
    				// console.log("just blew that hole");
    				publishNote("{{ asset('images/happygilmore.gif') }}", '<strong>SEEEEE YA!</strong><br/>'+ teamName +' just blew <b>Hole #' + hole + '</b>.<br/><i>Terrible Hole </i><span class="redicon"><i class="fa fa-times"></i></span>');
    				// publishMSG('fa-frown-o', teamName + " just blew it on<br/><b>Hole:</b> #" + hole);
    			}		
    		}
    	}
    }

    function publishMSG(icon, text){
    	var html = '<div class="row"><div class="col-xs-2"><div class="note-icon"><i class="green-text fa fa-lg ' + icon + '"></i></div> </div><div class="col-xs-10">' + text + '</div></div>';
    	var time = moment().format();
    	var notification = html + '|' + time;
      	message = new Paho.MQTT.Message(notification);
      	message.destinationName = "fc/notify/score";
      	client.send(message);
      	saveNotification(html);
    }

    function publishNote(image, htmlString){
    	var html = '<div class="row"><div class="col-xs-5"><img class="img-responsive img-cover" src="' + image + '" /></div><div class="col-xs-7">'+htmlString+'</div></div>';
    	var time = moment().format();
    	var notification = html + '|' + time;
      	message = new Paho.MQTT.Message(notification);
      	message.destinationName = "fc/notify/score";
      	client.send(message);
      	saveNotification(html);
    }


	function getLocation(){

		if(navigator.geolocation)
		{
			navigator.geolocation.watchPosition(
				function(position) {
					var hole = 1;
					if(currentHole > 0){
						hole = currentHole;
					}
					var myLat = position.coords.latitude;
					var myLon = position.coords.longitude;
					var pinLat = $("#pinLat" + hole).val();
					var pinLon = $("#pinLon" + hole).val();
					// var tempLat = "43.39028106";
					// var tempLon = "-79.81139839";
					calculateDistance(myLat, myLon, pinLat, pinLon, hole);
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


	function calculateDistance(lat1,lon1,lat2,lon2, hole) {
	  	var R = 6371; // Radius of the earth in km
	  	var dLat = deg2rad(lat2-lat1);  // deg2rad below
	  	var dLon = deg2rad(lon2-lon1); 
	  	var a = 
	    	Math.sin(dLat/2) * Math.sin(dLat/2) +
	    	Math.cos(deg2rad(lat1)) * Math.cos(deg2rad(lat2)) * 
	    	Math.sin(dLon/2) * Math.sin(dLon/2); 
	  	var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a)); 
	  	var km = R * c; // Distance in km
	  	var yd = Math.round(km/0.0009144);
	  	$("#pin-val" + hole).html("<strong>" + yd + " yd</strong>");
		getClub(yd, hole);
	}

	function deg2rad(deg) {
	  	return deg * (Math.PI/180)
	}

   	Number.prototype.between = function (min, max) {
		return this > min && this < max;
	};

	function getClub(yd, hole){
		var club = "";
		if((yd).between(210, 400)) {
			club = "DR";
		} else if((yd).between(190, 210)){
			club = "3W";
		} else if((yd).between(180, 190)){
			club = "2I";
		} else if((yd).between(170, 180)){
			club = "3I";
		}else if((yd).between(160, 170)){
			club = "4I";
		}else if((yd).between(150, 160)){
			club = "5I";
		}else if((yd).between(140, 150)){
			club = "6I";
		}else if((yd).between(130, 140)){
			club = "7I";
		}else if((yd).between(120, 130)){
			club = "8I";
		}else if((yd).between(100, 120)){
			club = "9I";
		}else if((yd).between(40, 100)){
			club = "PW";
		}else if((yd).between(30, 40)){
			club = "SW";
		}else if((yd).between(20, 30)){
			club = "LW";
		}else if((yd).between(1, 20)){
			club = "PT";
		} else {
			club = "To Far";
			// console.log("OUT OF RANGE");
		}

		$("#club" + hole).html("<strong>" + club + "</strong>");
	}


// *********************************************
// ******************* MQTT ********************
// *********************************************

    var client = new Paho.MQTT.Client("iot.eclipse.org", Number(443), "fc_client_" + userID);
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
        	if(data[0] == teamID){
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
   
    // Try HTML5 geolocation.
    navigator.geolocation.watchPosition(
        function(position) {
            var lat = position.coords.latitude;
            var lon = position.coords.longitude;
            // publishPosition(lat, lon);
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
      	message = new Paho.MQTT.Message(lat + ',' + lon + ',' + userAvatar + ',' + teamName);
      	message.destinationName = "fc/position/" + userID;
      	client.send(message);
    }

// *********************************************
// ******************* END ********************
// *********************************************


</script>
@endsection