@extends('layouts.master')
@section('title')
<i class="fa fa-code"></i> {{ __('messages.tinker') }}
@endsection

@section('subtitle')
{{ __('messages.tinkersub') }}
@endsection

@section('content')
<form role="form" class="form-horizontal">
	<div class="form-group">
		<label for="textareacode" class="col-sm-2 control-label">Code</label>
		<div class="col-sm-8">
			<textarea name="code" id="textareacode" class="form-control" rows="10" required="required" autofocus></textarea>
		</div>
	</div>
	<div class="form-group">
		<div class="col-sm-8 col-sm-offset-2">
			<button type="button" class="btn btn-primary pull-right" onclick="sendCode($('#textareacode').val())">{{ __('messages.run') }}</button>
		</div>
	</div>
</form>
<div class="box-footer">
	<label for="preCodeOutput" class="control-label">Output</label>
	<pre id="preCodeOutput" style="font-size: 1.2rem; background-color: light-gray; color: black;">NULL</pre>
</div>
@endsection
@push('scripts')
<script type="text/javascript" charset="utf-8">
	$( document ).ajaxError(function( event, request, settings ) {
		console.log(request.responseJSON);
		$('#preCodeOutput').html('ERROR: ' + request.status + ':' + request.statusText + '\n').append(request.responseText);
	});
	function sendCode(text) {
		if (text) {
			$.post('{{ route('admin.runtinker') }}', {'c' : text}, function (data) {
				$('#preCodeOutput').html(data);
			});
			$('#preCodeOutput').html('');
		}
	}
</script>
@endpush