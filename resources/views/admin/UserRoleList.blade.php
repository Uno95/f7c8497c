@extends('layouts.adminbase')

@section('specialLinkName')
Tambah Hak Akses
@stop

@section('specialLinkUrl')
add-role
@stop

@section('content')
<div class="col-md-12">
    <div class="col-md-3">
        <div class="itemRole">
            <a href="/add-permission" id="btnAddPermission" data-toggle="tooltip" 
                data-placement="top" title="Tambah Permission">
                <span class="glyphicon glyphicon-edit"></span>
            </a>
            <a href="#" id="btnDltItem" data-toggle="tooltip" data-placement="top" title="Hapus">
                <span class="glyphicon glyphicon-trash"></span>
            </a>
            <h4>Admin</h4>
            <div class="permission">
                <span class="label label-warning">Create User</span>
            </div>  
        </div>
    </div>
</div>
@stop