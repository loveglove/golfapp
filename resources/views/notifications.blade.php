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

<div class="wrapper wrapper-content animated fadeInDown">
	<br/>
    <div class="row">

        <div class="ibox float-e-margins" style="margin-left: 5px;">
            <div class="ibox-content">
                @if(!$notifications->isEmpty())
                    @foreach ($notifications as $note)
                        <div class="note-container">
                            {!! $note->text !!}
                            <div class="row">
                                <span class="pull-right text-muted small slate-text extra-pad" style="margin-right: 10px;"><br>
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

@endsection


