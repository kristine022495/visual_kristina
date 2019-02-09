@extends('authentication.dashboard')

@section('header')
<style>

  .card {
    margin: auto;
    width: fit-content;
    margin-top: 40px;
  }

  .errors {
    color: red;
  }

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

    .circle i {
      font-size: 63px;
    }
</style>
@endsection

@section('main-content')

<div class="card">
  <div class="card-body">
    <div style="text-align:center">
      <h5 class="card-title">Add a User</h5>
      <h6 class="card-subtitle mb-2 text-muted">Enter user details</h6>
      <hr>
    </div>
    <!-- <p class="card-text"></p> -->
    <form class="container" method="POST" action="/accounts/add">

      @csrf

      <div class="form-group">
        <label for="name">Name</label>
        <input type="text" class="form-control" id="name" name="name" required>
        <small id="emailHelp" class="form-text text-muted">Enter Your full name</small>
      </div>
      <div class="errors">
        <p>{{ Session::get('error_existing') }}</p>
      </div>
      <div class="form-group">
        <label for="name">Username</label>
        <input type="text" class="form-control" id="username" name="username" required>
        <small id="emailHelp" class="form-text text-muted">The username is automatically generated but is editable.</small>
      </div>
      <div class="errors">
        <p>{{ Session::get('error_password') }}</p>
      </div>
      <div class="form-group">
        <label for="password">Password</label>
        <input type="password" class="form-control" id="password" name="password" required>
      </div>
      <div class="form-group">
        <label for="password">Confirm Password</label>
        <input type="password" class="form-control" id="password" name="password_confirmation" required>
      </div>
      <label for="role">Role</label>
      <select class="custom-select" id="role" name="role" required>
        <option selected>Select Role</option>
        <option value="administrator">Administrator</option>
        <option value="faculty">Faculty</option>
        <option value="staff">Staff</option>
        <option value="assistant">Student Assistant</option>
      </select> <br><br>
      <div class="display:flex" style="text-align:right">
        <button type="submit" class="btn btn-primary active">Save</button>
      </div>
    </form>
  </div>
</div>
<br>

@endsection

@section('scripts')

<script type="text/javascript">
  // $('#name').on('change key down', function() {
  //   var str = $('#name').val();
  //   var name = str.split(' ');
  //   var first = name[0][0];
  //   var last = name[name.length-1];
  //   var username = first+last;
  //   $('#username').val(username.toLowerCase());
  // });
</script>

@endsection
