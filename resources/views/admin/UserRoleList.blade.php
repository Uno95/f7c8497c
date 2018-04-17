@extends('layouts.adminbase')

@section('specialLinkName')
Tambah Hak Akses
@stop

@section('specialLinkUrl')
add-role
@stop

@section('content')
<div class="col-md-12">
    @foreach ($roles as $role)
    <div class="col-md-3">
        <div class="itemRole">
            <a href="/add-permission" id="btnAddPermission" data-toggle="tooltip" 
                data-placement="top" title="Tambah Permission">
                <span class="glyphicon glyphicon-edit"></span>
            </a>
            <a href="#" id="btnDltItem" data-toggle="tooltip" data-placement="top" title="Hapus">
                <span class="glyphicon glyphicon-trash"></span>
            </a>
            <h4>{{ $role->display_name }}</h4>
            <div class="permission">
                @if (count($role->permissions) > 0)
                <span class="label label-info">
                    @foreach ($role->permissions as $permission)
                    {{ $permission->display_name }}
                    @endforeach
                </span>
                @else
                <span class="label label-warning">Not Have Permission</span>
                @endif
            </div>  
        </div>
    </div>
    @endforeach
</div>
@stop