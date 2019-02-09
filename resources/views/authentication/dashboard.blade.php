@extends('layouts.master')

@section('header')
  <style>
    .circle {
      height: 50px;
      width: 50px;
      background-color: #b61827;
      border-radius: 100%;
      float: left;
      margin-right: 10px;
      display: flex;
      align-items: center;
      justify-content: center;
    }
  </style>
@endsection

@section('content')

  <!-- Side navigation -->
  <div class="sidenav">
    <div style="padding:20px;padding-bottom:0">
      <div class="circle"><i class="material-icons">account_circle</i></div>
      <div style="margin-left:10px">
        <h5 class="card-title">{{ '@' . Auth::user()->username }}</h5>
        <h6 class="card-subtitle mb-2 text-muted">{{ ucfirst(Auth::user()->role) }}</h6><hr>
      </div>
    </div>
    <ul class="list-group bmd-list-group-sm" style="margin-top:10px;">
      <li class="list-group-item"><h5>File Manager</h5></li>
      <div style="padding-left:15px">
        <a href="/dashboard" class="list-group-item"><i class="material-icons">home</i>Dashboard</a>
        <a href="/files/folders" class="list-group-item"><i class="material-icons">folder_open</i>Folders</a>
        <a href="/files/search" class="list-group-item"><i class="material-icons">search</i>Search</a>
        <a href="/files/upload" class="list-group-item"><i class="material-icons">cloud_upload</i>Upload</a>
      </div>
    </ul>
    <!-- Show Accounts Manager if user is an admin -->
    <?php if (Auth::user()->role == 'administrator') : ?>
      <ul class="list-group bmd-list-group-sm" style="margin-top:10px;">
        <li class="list-group-item"><h5>Admin Access</h5></li>
        <div style="padding-left:15px">
          <a href="/accounts/add" class="list-group-item"><i class="material-icons">group_add</i>Add user</a>
          <a href="/accounts/list" class="list-group-item"><i class="material-icons">group</i>Accounts</a>
          <a href="/files/folders/manage" class="list-group-item"><i class="material-icons">folder_shared</i>Manage Folders</a>
        </div>
      </ul>
    <?php endif; ?>
  </div>

  <!-- Page content -->
  <div class="main">
    @yield('main-content')
  </div>

@endsection
