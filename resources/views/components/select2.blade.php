<select class="select2 form-control" name="{{ $name }}{{ $multiple ? '[]' : '' }}" id="{{ $name }}" style="width: 100%;" {{ $multiple ? 'multiple' : '' }}>
    @foreach ($datasource as $data)
    @php
    $selected = ''
    @endphp
    @if (!empty(old('{$name}')))
    @foreach (old('{$name}') as $old)
    @if ($old == $data->id)
    @php
    $selected = 'selected'
    @endphp
    @endif
    @endforeach
    @else
    @foreach ($values as $value)
    @if ($value->id === $data->id)
    @php
    $selected = 'selected'
    @endphp
    @endif
    @endforeach
    @endif
    <option value="{{ $data->id }}" {{ $selected }}>{{ $data->name }}</option>
    @endforeach
</select> 
@if ($errors->has('{$name}'))
<span class="help-block" role="alert">
    <strong>{{ $errors->first('{$name}') }}</strong>
</span> 
@endif

@push('scripts')

<script>
    $(function() {
        $('#{{ $name }}').select2({
            placeholder: " {{ __('messages.'.$name) }}",
            allowClear: true
        });
    });
</script>

@endpush
