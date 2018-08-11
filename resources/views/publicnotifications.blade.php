@extends('layouts.master_public')


@section('content')
<style>
	.note-container{
		padding:2px 10px;
		/*border-bottom:1px solid #eee;*/
	}
    .extra-pad{
       /* padding:2px 0px;*/
    }

    #note-icon{
        display: none !important;
    }

</style>

<div class="wrapper wrapper-content animated fadeInRight">
	<br/>
    <div class="row">
        <div class="col-md-offset-3 col-md-6">
        <div class="ibox float-e-margins">
            <div class="ibox-content">
                @if(!$notifications->isEmpty())
                    @foreach ($notifications as $note)
                        <div class="note-container">
                            {!! $note->text !!}
                            <div class="row">
                                <span class="pull-right text-muted small slate-text extra-pad"><br>
                                    {{ $note->created_at->diffForHumans() }}
                                </span>
                            </div>
                        </div>
                        <hr>
                    @endforeach
                @else
                    <h4>No Notifications Yet!</h4>
                @endif
            </div>
        </div>
    </div>
    </div>

</div>

@endsection