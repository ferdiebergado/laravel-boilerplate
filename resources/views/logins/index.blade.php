@extends('layouts.master')

@section('title')
<i class="fa fa-lock"></i> {{  __('messages.logins') }}
@endsection

@section('subtitle')
{{  __('messages.loginssub') }}
@endsection

@section('content')
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="table-responsive">
            <table id="logins-table" class="table table-hover table-striped table-condensed dataTable js-exportable" style="font-size: 1.3rem;"></table>
        </div>
    </div>
</div>
@endsection

@push('scripts')

@php
$url = route('admin.logins.index')
@endphp

@component('datatablejs')

@slot('datatableid')
logins-table
@endslot

@slot('datatableroute')
{!! $url !!}
@endslot

@slot('datatablewith')
user
@endslot

@slot('ellipsiscol')
[1, 2]
@endslot

@slot('columns')
{ name: 'id', title: 'ID', data: 'id', width: '5%' },
{ name: 'name', title: 'Name', data: 'user.name', width: '20%' },
{ name: 'ip', title: 'IP', data: 'ip', width: '15%' },
{ name: 'user_agent', title: 'User Agent', data: 'user_agent', width: '35%' },
{ name: 'via_remember', title: 'Remember', data: 'via_remember', width: '5%' },
{ name: 'date_created', title: 'Date', data: 'date_created', width: '15%' },
@endslot

{{--  ID  --}}
{ targets: 0,
    render: function (data, type, row) {
        return `<span class=\ "label bg-gray\">${data}</span>`;
    }
},
{{--  /ID  --}}

{ targets: 4,
    render: function(data, type, row) {
        if (data != null && data == 1) {
            return `<span class=\"text-success\"><i class=\"fa fa-check\"></i></span>`;
        } else {
            return `<span class=\"text-muted\"><i class=\"fa fa-ban\"></i></span>`;
        }
    },
    className: "text-center"
},

@slot('toolbar')
@endslot

@endcomponent

@endpush