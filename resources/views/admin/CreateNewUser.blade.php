@extends('layouts.adminbase')

@section('content')
<div class="col-md-2"></div>
<div class="col-md-8">
    <div class="whiteCover newPermission">
        <h2>Tambahkan Pengguna Baru</h2>
        <form class="form-horizontal" action="{{ route('register') }}" method="POST">
            {{ csrf_field() }}
            <div class="form-group">
                <label for="name" class="col-sm-2 control-label">Name</label>
                <div class="col-sm-10">
                <input type="text" name="name" class="form-control" 
                    id="name" placeholder="Ex: create-post">
                </div>
            </div>
            <div class="form-group">
                <label for="email" class="col-sm-2 control-label">Email</label>
                <div class="col-sm-10">
                <input type="email" name="email" class="form-control" 
                    id="email" placeholder="Create Post">
                </div>
            </div>
            <div class="form-group">
                <label for="role" class="col-sm-2 control-label">Hak Akses</label>
                <div class="col-sm-10" id="role">
                    <select class="form-control" name="role">
                        <option value="admin">Admin</option>
                        <option value="admin">Manajemen</option>
                        <option value="admin">Produksi</option>
                        <option value="admin">Marketing</option>
                        <option value="admin">Gudang</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">Password</label>
                <div class="col-sm-10">
                    <input id="password" type="password" class="form-control" name="password" required>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">Konfirmasi Password</label>
                <div class="col-sm-10">
                    <input id="password-confirm" type="password" 
                        class="form-control" name="password_confirmation" required>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-primary">Tambahkan</button>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="col-md-2"></div>
@stop