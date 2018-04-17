@extends('layouts.adminbase')

@section('specialLinkName')
Tambah Pengguna
@stop

@section('specialLinkUrl')
add-user
@stop

@section('content')
<div class="col-md-12">
    @foreach ($users as $user)
    <div class="col-md-3">
        <div class="itemRole">
            <a href="/edit-user" id="btnEditItem" data-toggle="tooltip" 
                data-placement="top" title="Edit Pengguna">
                <span class="glyphicon glyphicon-edit"></span>
            </a>
            <a href="/dlt-user" id="btnDltItem" data-toggle="tooltip" data-placement="top" title="Hapus Pengguna">
                <span class="glyphicon glyphicon-trash"></span>
            </a>
            <h4>{{ $user->name }}</h4>
            <div class="permission">
                @if (count($user->roles) > 0)
                <span class="label label-info">{{ $user->roles[0]->display_name }}</span>
                @else
                <span class="label label-warning">Not Have Access</span>
                @endif
            </div>  
        </div>
    </div>
    @endforeach
</div>
@stop