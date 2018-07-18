@extends('layouts.master')

@section('title')
<i class="fa fa-users"></i> {{  __('messages.users') }}
@endsection

@section('subtitle')
{{ __('messages.userssub') }}
@endsection

@section('content')
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="table-responsive">
            <table id="users-table" class="table table-hover table-striped table-condensed dataTable js-exportable" style="font-size: 1.3rem;"></table>
        </div>
    </div>
</div>
@endsection

@push('scripts')

@php
$url = route('admin.users.index')
@endphp

@component('datatablejs')

@slot('datatableid')
users-table
@endslot

@slot('datatableroute')
{!! $url !!}
@endslot

@slot('datatablewith')
roles,permissions
@endslot

@slot('ellipsiscol')
[1, 2]
@endslot

@slot('columns')
{ name: 'id', title: 'ID', data: 'id', width: '5%' },
{ name: 'name', title: 'Name', data: 'name', width: '25%' },
{ name: 'email', title: 'Email', data: 'email', width: '20%' },
{ name: 'verified', title: 'Verified', data: 'verified', width: '5%' },
{ name: 'roles', title: 'Role(s)', data: 'roles', width: '15%' },
{ name: 'active', title: 'Active', data: 'active', width: '5%' },
{ name: 'last_login_at', title: 'Last Login', data: 'last_login_at', width: '10%' },
{ title: 'Task(s)', data: 'id', searchable: false, orderable: false, width: '15%' }
@endslot

{ targets: 0,
    render: function (data, type, row) {
        return `<span class=\ "label bg-gray\">${data}</span>`;
    }
},
{ targets: 3,
    render: function(data, type, row) {
        if (data != null && data == 1) {
            return `<span class=\"label label-info\"><i class=\"fa fa-check\"></i></span>`;
        } else {
            return `<span class=\ "label label-danger\"><i class=\"fa fa-ban\"></i></span>`;
        }
    },
    className: "text-center"
},
{ targets: 4,
    render: function(data, type, row) {
        if (data) {
            var d = '';
            $.each(row.roles, function(k, v) {
                d += `<span class=\"label label-success\">${v.slug}</span> `;
            });
            return d;
        }
    }
},
{ targets: 5,
    render: function(data, type, row) {
        if (data != null && data == 1) {
            return `<span class=\"text-success\"><i class=\"fa fa-check\"></i></span>`;
        } else {
            return `<span class=\"text-muted\"><i class=\"fa fa-ban\"></i></span>`;
        }
    },
    className: "text-center"
},
{ targets: 7,
    render: function(data, type, row) {
        btnclass = "btn btn-sm btn-flat";
        baseurl = "{!! $url !!}";
        viewurl = `<a class="${btnclass} btn-info" href="${baseurl}/${data}" title="{{ __('View') }}"><i class="fa fa-eye"></i></a> `;
        editurl = `<a class="${btnclass} btn-primary" href="${baseurl}/${data}/edit" title="{{ __('Edit') }}"><i class="fa fa-edit"></i></a> `;
        delurl = `<form id="del-form-${data}" method="POST" action="${baseurl}/${data}" style="display: inline;">
            {{ method_field('DELETE') }}
            {{ csrf_field() }}
            <a href="#" class="${btnclass} btn-warning" title="{{ __('messages.delete') }}" onclick="if (confirm('Are your sure?')) { document.querySelector('#del-form-${data}').submit(); }"><i class="fa fa-trash"></i></a>
        </form>`;
        return viewurl + editurl + delurl;
    },
    className: "text-center"
}

@section('boxtools')

@if (auth()->user()->hasPermissionTo('create-users'))
<a href="{{ route('admin.users.create') }}" class="btn btn-flat btn-sm btn-primary pull-right" style="margin-left: 5px" title="{{ __('messages.adduser') }}"><i class="fa fa-user-plus"></i> New</a>
@endif

@endsection

@slot('toolbar')
@endslot

@endcomponent

@endpush