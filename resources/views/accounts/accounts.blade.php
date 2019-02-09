@extends('authentication.dashboard')

@section('header')
<style>

  .card {
    margin: auto;
    width: fit-content;
    margin-top: 40px;
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
      <h5 class="card-title">Accounts List</h5>
    </div>
    <table class="table table-hover">
      <thead>
        <tr>
          <th scope="col">Username</th>
          <th scope="col">Name</th>
          <th scope="col">Role</th>
          <th scope="col">Profile</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($accounts as $account) : ?>
          <tr>
            <td>{{ $account->username }}</td>
            <td>{{ $account->name }}</td>
            <td>{{ $account->role }}</td>
            <td>
              <a href="/accounts/view/{{ $account->username }}">View</a>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>

@endsection
