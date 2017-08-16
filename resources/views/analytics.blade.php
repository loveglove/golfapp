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
		font-size: 14px;
	}
	.touravg{
		color: rgba(170,170,170,1);
		text-align: right;
		font-weight: 500;
		font-size: 14px;
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
					<span class="pie">{{ $statistics['holeinones'] }},18</span>
				</div>
			</div>
		@endif

		@if(!empty($statistics['albatrosses']))
			<div class="col-xs-6">
				<div class="col-xs-9">
					<label class="label label-custom" style="background-color:#33cccc;">{{ $statistics['albatrosses'] }}</label> Albatrosses
				</div> 
				<div class="col-xs-3">
					<span class="pie">{{ $statistics['albatrosses'] }},18</span>
				</div>
			</div>
		@endif

		@if(!empty($statistics['eagles']))
			<div class="col-xs-6">
				<div class="col-xs-9">
					<label class="label label-custom" style="background-color:#33cccc;">{{ $statistics['eagles'] }}</label> Eagles
				</div>
				<div class="col-xs-3">
				 	<span class="pie">{{ $statistics['eagles'] }},18</span>
				</div>
			</div>
		@endif

		@if(!empty($statistics['birdies']))
			<div class="col-xs-6">
				<div class="col-xs-9">
					<label class="label label-custom" style="background-color:#54bc75;">{{ $statistics['birdies'] }}</label> Birdies 
				</div>
				<div class="col-xs-3">
					<span class="pie">{{ $statistics['birdies'] }},18</span>
				</div>
			</div>
		@endif

		@if(!empty($statistics['pars']))
			<div class="col-xs-6">
				<div class="col-xs-9">
					<label class="label label-custom" style="background-color:#89C558;">{{ $statistics['pars'] }}</label> Pars
				</div>  
				<div class="col-xs-3">
					<span class="pie">{{ $statistics['pars'] }},18</span>
				</div>
			</div>
		@endif

		@if(!empty($statistics['bogeys']))
			<div class="col-xs-6">
				<div class="col-xs-9">
					<label class="label label-custom" style="background-color:#B9CC54;">{{ $statistics['bogeys'] }}</label> Bogeys 
				</div>
				<div class="col-xs-3">
					<span class="pie">{{ $statistics['bogeys'] }},18</span>
				</div>
			</div>
		@endif

		@if(!empty($statistics['doublebogeys']))
			<div class="col-xs-6">
				<div class="col-xs-9">
					<label class="label label-custom" style="background-color:#D4B64F;">{{ $statistics['doublebogeys'] }}</label> Doubles 
				</div>
				<div class="col-xs-3">
					<span class="pie">{{ $statistics['doublebogeys'] }},18</span>
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

</div>


@endsection

@section('scripts')
<script src="{{{ asset('/theme/js/plugins/peity/jquery.peity.min.js') }}}"></script>
<script src="{{{ asset('/theme/js/plugins/chartJs/Chart.min.js') }}}"></script>
<script>

	$(document).ready(function(){
		
		$("span.pie").peity("pie", {
        	fill: ['#62BE5C', '#d7d7d7', '#ffffff']
    	});

    	var radarData = {
	        labels: ["Hole #1", "Hole #2", "Hole #3", "Hole #4", "Hole #5", "Hole #6", "Hole #7", "Hole #8", "Hole #9", "Hole #10", "Hole #11", "Hole #12", "Hole #13", "Hole #14","Hole #15", "Hole #16", "Hole #17", "Hole #18",],
	        datasets: [
	            {
	                label: "My Score",
	                fillColor: "rgba(170,170,170,0.2)",
	                strokeColor: "rgba(170,170,170,1)",
	                pointColor: "rgba(170,170,170,1)",
	                pointStrokeColor: "#fff",
	                pointHighlightFill: "#fff",
	                pointHighlightStroke: "rgba(170,170,170,1)",
	                data: [3, 3, 4, 6, 5, 3, 4, 5, 6, 5, 3, 4, 3, 2, 3, 4, 4, 5]
	            },
	            {
	                label: "Tournament Average",
	                fillColor: "rgba(98,190,92,0.2)",
	                strokeColor: "rgba(98,190,92,1)",
	                pointColor: "rgba(98,190,92,1)",
	                pointStrokeColor: "#fff",
	                pointHighlightFill: "#fff",
	                pointHighlightStroke: "rgba(98,190,92,1)",
	                data: [4, 3, 4, 5, 3, 4, 3, 5, 4, 5, 3, 4, 3, 3, 4, 5, 4, 5]
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

	    // var legendOptions = {
	    // 	fullWidth: true,
	    // }

	    var ctx = document.getElementById("over-under").getContext("2d");
	    var myNewChart = new Chart(ctx).Radar(radarData, radarOptions);


	});



</script>



@endsection