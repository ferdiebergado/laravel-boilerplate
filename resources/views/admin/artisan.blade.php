@extends('layouts.master')

@section('title')
<i class="fa fa-terminal"></i> {{ __('messages.commands') }}
@endsection

@section('subtitle')
{{ __('messages.commandssub') }}
@endsection

@section('content')
<form role="form">
	<div class="form-group">
		<label for="command">Command:</label>

		<div class="input-group">
			<div class="input-group-addon">&gt; artisan </div>
			<input type="text" class="form-control" id="command" name="command" placeholder="Enter command here." autofocus>
			<span class="input-group-btn">
				<button id="btnArtisanCommand" class="btn btn-primary"><i class="fa fa-level-up"></i></button>
			</span>
		</div>
	</div>
</form>
<label for="preArtisanOutput">Output:</label>
<pre id="preArtisanOutput" style="font-size: 1.2rem; background-color: light-gray; color: black;">NULL</pre>
@endsection

@push('scripts')
<script type="text/javascript">
	$(document).ready(function() {
		function executeCommand(e) {
			var command = String($('#command').val().toLowerCase());
			e.preventDefault();
			$.post("{{ route('admin.run_command') }}", { "command" : command }, function(data) {
				$('#preArtisanOutput').html(data); });
			$('#command').val('');
		}
		$('#btnArtisanCommand').click(function(e) {
			executeCommand(e);
		});
		$('#command').keydown(function(event) {
		 	const KEY_ENTER = 13;
		 	var key = event.which || event.keyCode;
		 	if (key == KEY_ENTER) {
				 executeCommand(event);
		 	}
		});
	});
</script>
@endpush
