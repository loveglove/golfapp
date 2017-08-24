@extends('layouts.master')

@section('scripts')


@endsection




@section('content')
<style>
	.note-container{
		padding:2px 10px;
		/*border-bottom:1px solid #eee;*/
	}
    .extra-pad{
       /* padding:2px 0px;*/
    }
</style>

<div class="wrapper wrapper-content animated fadeInRight">
	<br/>
    <div class="row">

        <div class="ibox float-e-margins">
            <div class="ibox-content">
            	@foreach ($notifications as $note)
            		<div class="note-container">
						{!! $note->text !!}
                        <div class="row">
    						<span class="pull-right text-muted small slate-text extra-pad">
                                {{ $note->created_at->diffForHumans() }}
    						</span>
                        </div>
					</div>
                    <hr>
            	@endforeach
            </div>
        </div>
    </div>

</div>

@endsection


