@extends('layouts.adminbase')

@section('specialLinkName')
Tambah Pengguna
@stop

@section('specialLinkUrl')
add-user
@stop

@section('content')
<div class="col-md-12">
    <div class="col-md-3">
        <div class="itemRole">
            <a href="/edit-user" id="btnEditItem" data-toggle="tooltip" 
                data-placement="top" title="Edit Pengguna">
                <span class="glyphicon glyphicon-edit"></span>
            </a>
            <a href="/dlt-user" id="btnDltItem" data-toggle="tooltip" data-placement="top" title="Hapus Pengguna">
                <span class="glyphicon glyphicon-trash"></span>
            </a>
            <h4>Adrian</h4>
            <div class="permission">
                <span class="label label-info">Admin</span>
            </div>  
        </div>
    </div>
</div>
@stop