<input id="{{ $name }}" type="checkbox" class="form-control" name="{{ $name }}" {{ $condition ? 'checked' : '' }}>

@push('scripts')

<script>
    $(function() {
        var el = $('#{{ $name }}');
        el.val({{ $condition }});
        el.on('ifToggled', function() {
            $(this).val(Number(this.checked));
        });
    });
</script>

@endpush
