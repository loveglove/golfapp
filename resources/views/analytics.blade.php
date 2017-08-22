@extends('layouts.master')


@section('content')
<!-- Morris -->
<!-- <link href="{{{ asset('/theme/css/plugins/morris/morris-0.4.3.min.css') }}}" rel="stylesheet"> -->
<style>
	.label-custom{
		color:white !important;
		font-weight: 500;
		margin: 0px !important;
		font-size: 12px !important;
	}
	.count-fields{
		margin:15px 0px !important;
		font-size:14px !important;
	}
	.count-fields > div{
		padding:8px 0px;
	}
	.myscore{
		color: rgba(98,190,92,1);
		text-align: left;
		font-weight: 500;
		font-size: 15px;
	}
	.touravg{
		color: rgba(170,170,170,1);
		text-align: right;
		font-weight: 500;
		font-size: 15px;
	}

</style>


<div class="wrapper wrapper-content animated fadeInRight">
 
	<div class="row count-fields">

  		@if(!empty($statistics['holeinones']))
  			<div class="col-xs-6">
  				<div class="col-xs-9">
					<label class="label label-custom" style="background-color:#33cccc;">{{ $statistics['holeinones'] }}</label> Hole In Ones 
				</div>
				<div class="col-xs-3">
					<span class="pie">{{ $statistics['holeinones'] }},{{ count($myscores) }}</span>
				</div>
			</div>
		@endif

		@if(!empty($statistics['albatrosses']))
			<div class="col-xs-6">
				<div class="col-xs-9">
					<label class="label label-custom" style="background-color:#33cccc;">{{ $statistics['albatrosses'] }}</label> Albatrosses
				</div> 
				<div class="col-xs-3">
					<span class="pie">{{ $statistics['albatrosses'] }},{{ count($myscores) }}</span>
				</div>
			</div>
		@endif

		@if(!empty($statistics['eagles']))
			<div class="col-xs-6">
				<div class="col-xs-9">
					<label class="label label-custom" style="background-color:#33cccc;">{{ $statistics['eagles'] }}</label> Eagles
				</div>
				<div class="col-xs-3">
				 	<span class="pie">{{ $statistics['eagles'] }},{{ count($myscores) }}</span>
				</div>
			</div>
		@endif

		@if(!empty($statistics['birdies']))
			<div class="col-xs-6">
				<div class="col-xs-9">
					<label class="label label-custom" style="background-color:#54bc75;">{{ $statistics['birdies'] }}</label> Birdies 
				</div>
				<div class="col-xs-3">
					<span class="pie">{{ $statistics['birdies'] }},{{ count($myscores) }}</span>
				</div>
			</div>
		@endif

		@if(!empty($statistics['pars']))
			<div class="col-xs-6">
				<div class="col-xs-9">
					<label class="label label-custom" style="background-color:#89C558;">{{ $statistics['pars'] }}</label> Pars
				</div>  
				<div class="col-xs-3">
					<span class="pie">{{ $statistics['pars'] }},{{ count($myscores) }}</span>
				</div>
			</div>
		@endif

		@if(!empty($statistics['bogeys']))
			<div class="col-xs-6">
				<div class="col-xs-9">
					<label class="label label-custom" style="background-color:#B9CC54;">{{ $statistics['bogeys'] }}</label> Bogeys 
				</div>
				<div class="col-xs-3">
					<span class="pie">{{ $statistics['bogeys'] }},{{ count($myscores) }}</span>
				</div>
			</div>
		@endif

		@if(!empty($statistics['doublebogeys']))
			<div class="col-xs-6">
				<div class="col-xs-9">
					<label class="label label-custom" style="background-color:#D4B64F;">{{ $statistics['doublebogeys'] }}</label> Doubles 
				</div>
				<div class="col-xs-3">
					<span class="pie">{{ $statistics['doublebogeys'] }},{{ count($myscores) }}</span>
				</div>
			</div>
		@endif

	</div>

	<div class="row">
		<div class="col-xs-12">
            <div class="ibox float-e-margins">
                <div class="ibox-content">
            		<div class="col-xs-4 myscore">
            			My Score
            		</div>
            		<div class="col-xs-8 touravg">
            			Tournament Average
            		</div>
            		<div class="text-center">
            			<canvas id="over-under" height="320"></canvas>
            		</div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
		<div class="col-xs-12">
            <div class="ibox float-e-margins">
                <div class="ibox-content">
	                <div class="row">
	   					<div class="col-xs-7"><h2>Average Team <br/> Score Currently:</h2></div>
	   					<div class="col-xs-5">
	   						<span style="font-size:48px; float:right;">
		                    	@if($avgscore < 0)
		                    		<i class="fa fa-level-down green-text"></i>&nbsp{{ $avgscore }}
		                    	@elseif($avgscore > 0)
		                    		<i class="fa fa-level-up red-text"></i>&nbsp+{{ $avgscore }}
		                    	@else($avgscore == 0)
		                    		<i class="fa fa-minus"></i>&nbspE
		                    	@endif
	   					</div>
	                </div>
                </div>
            </div>
        </div>
    </div>

</div>


@endsection

@section('scripts')
<script src="{{{ asset('/theme/js/plugins/peity/jquery.peity.min.js') }}}"></script>
<script src="{{{ asset('/theme/js/plugins/chartJs/Chart.min.js') }}}"></script>
<script>

	var myscore = [<?php echo '"'.implode('","',  $myscores ).'"' ?>];
	var averages = [<?php echo '"'.implode('","',  $averages ).'"' ?>];

	var labelvals = [];

	$(document).ready(function(){
		
		$("span.pie").peity("pie", {
        	fill: ['#62BE5C', '#d7d7d7', '#ffffff']
    	});

		for(i = 0; i < myscore.length; i++){
		   	labelvals.push("Hole #" + (i + 1));
		} 

    	var radarData = {
	        labels: labelvals,
	        datasets: [
	            {
	                label: "My Score",
	                fillColor: "rgba(170,170,170,0.2)",
	                strokeColor: "rgba(170,170,170,1)",
	                pointColor: "rgba(170,170,170,1)",
	                pointStrokeColor: "#fff",
	                pointHighlightFill: "#fff",
	                pointHighlightStroke: "rgba(170,170,170,1)",
	                data: myscore
	            },
	            {
	                label: "Tournament Average",
	                fillColor: "rgba(98,190,92,0.2)",
	                strokeColor: "rgba(98,190,92,1)",
	                pointColor: "rgba(98,190,92,1)",
	                pointStrokeColor: "#fff",
	                pointHighlightFill: "#fff",
	                pointHighlightStroke: "rgba(98,190,92,1)",
	                data: averages
	            }
	        ]
	    };

	    var radarOptions = {
	        scaleShowLine: true,
	        angleShowLineOut: true,
	        scaleShowLabels: true,
	        scaleBeginAtZero: true,
	        angleLineColor: "rgba(0,0,0,.1)",
	        angleLineWidth: 1,
	        pointLabelFontFamily: "'Arial'",
	        pointLabelFontStyle: "normal",
	        pointLabelFontSize: 12,
	        pointLabelFontColor: "#999",
	        pointDot: true,
	        pointDotRadius: 3,
	        pointDotStrokeWidth: 1,
	        // pointHitDetectionRadius: 20,
	        datasetStroke: true,
	        datasetStrokeWidth: 2,
	        datasetFill: true,
	        responsive: true,
	    }


	    var ctx = document.getElementById("over-under").getContext("2d");
	    var myNewChart = new Chart(ctx).Radar(radarData, radarOptions);


	});



</script>



@endsection