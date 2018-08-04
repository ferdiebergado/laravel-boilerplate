@extends('layouts.master')

@section('title')
<i class="fa fa-tags"></i> {{  __('messages.roles') }}
@endsection

@section('subtitle')
{{ __('messages.rolessub') }}
@endsection

@section('content')
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="table-responsive">
            <table id="roles-table" class="table table-hover table-striped table-condensed dataTable js-exportable" style="font-size: 1.3rem;"></table>
        </div>
    </div>
</div>
@endsection

@push('scripts')

@php
$url = route('admin.roles.index')
@endphp

@component('datatablejs')

@slot('datatableid')
roles-table
@endslot

@slot('datatableroute')
{!! $url !!}
@endslot

@slot('datatablewith')
permissions
@endslot

@slot('ellipsiscol')
[1, 2]
@endslot

@slot('columns')
{ name: 'id', title: 'ID', data: 'id', width: '10%' },
{ name: 'name', title: 'Name', data: 'name', width: '15%' },
{ name: 'slug', title: 'Slug', data: 'slug', width: '15%' },
{ name: 'permissions', title: 'Permission(s)', data: 'permissions', width: '25%' },
{ name: 'created_at', title: 'Created At', data: 'created_at', width: '10%' },
{ name: 'updated_at', title: 'Updated At', data: 'updated_at', width: '10%' },
{ title: 'Task(s)', data: 'id', searchable: false, orderable: false, width: '15%' }
@endslot

{ targets: 0,
    render: function (data, type, row) {
        return `<span class=\ "label bg-gray\">${data}</span>`;
    }
},

{ targets: 3,
    render: function(data, type, row) {
        if (data) {
            var d = '';
            $.each(row.permissions, function(k, v) {
                d += `<span class=\"label label-success\">${v.slug}</span> `;
            });
            return d;
        }
    }
},

{ targets: 6,
    render: function(data, type, row) {
        btnclass = "btn btn-sm btn-flat";
        baseurl = "{!! $url !!}";
        {{--  viewurl = `<a class="${btnclass} btn-info" href="${baseurl}/${data}" title="{{ __('View') }}"><i class="fa fa-eye"></i></a> `;  --}}
        editurl = `<a class="${btnclass} btn-primary" href="${baseurl}/${data}/edit" title="{{ __('Edit') }}"><i class="fa fa-edit"></i></a> `;
        delurl = `<form id="del-form-${data}" method="POST" action="${baseurl}/${data}" style="display: inline;">
            {{ method_field('DELETE') }}
            {{ csrf_field() }}
            <a href="#" class="${btnclass} btn-warning" title="{{ __('messages.delete') }}" onclick="if (confirm('Are your sure?')) { document.querySelector('#del-form-${data}').submit(); }"><i class="fa fa-trash"></i></a>
        </form>`;
        return editurl + delurl;
    },
    className: "text-center"
}

@section('boxtools')

@if (auth()->user()->hasPermissionTo('create-roles'))
<a href="{{ route('admin.roles.create') }}" class="btn btn-flat btn-sm btn-primary pull-right" style="margin-left: 5px" title="{{ __('messages.addroles') }}"><i class="fa fa-user-plus"></i> New</a>
@endif

@endsection

@slot('toolbar')
@endslot

@endcomponent

@endpush