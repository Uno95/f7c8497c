@extends('layouts.adminbase')

@section('content')
<div class="col-md-2"></div>
<div class="col-md-8">
    <div class="whiteCover newPermission">
        <h2>Tambahkan Pengguna Baru</h2>
        <form class="form-horizontal">
            <div class="form-group">
                <label for="newPermissionName" class="col-sm-2 control-label">Name</label>
                <div class="col-sm-10">
                <input type="text" name="newPermissionName" class="form-control" 
                    id="newPermissionName" placeholder="Ex: create-post">
                </div>
            </div>
            <div class="form-group">
                <label for="permissionLabel" class="col-sm-2 control-label">Email</label>
                <div class="col-sm-10">
                <input type="email" name="permissionLabel" class="form-control" 
                    id="permissionLabel" placeholder="Create Post">
                </div>
            </div>
            <div class="form-group">
                <label for="permissionName" class="col-sm-2 control-label">Hak Akses</label>
                <div class="col-sm-10" id="permissionName" name="permissionName">
                    <select class="form-control">
                        <option>Admin</option>
                        <option>Manajemen</option>
                        <option>Produksi</option>
                        <option>Marketing</option>
                        <option>Gudang</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">Password</label>
                <div class="col-sm-10">
                    <textarea class="form-control" rows="3" name="description"></textarea>
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