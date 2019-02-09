@extends('authentication.dashboard')

@section('header')

<meta name="csrf-token" content="{{ csrf_token() }}">

<style>

  .card {
    margin: auto;
    width: 80%;
    margin-top: 40px;
  }

  .circle-view {
    height: 80px;
    width: 80px;
    background-color: #b61827;
    border-radius: 100%;
  }

  .success {
    color: green;
  }

</style>
@endsection

@section('main-content')

<?php if(Session::has('success_create_user')) : ?>
  <div class="card success">
    <div class="card-body">
      <p>{{ Session::get('success_create_user') }}</p>
      <p>See details below</p>
    </div>
  </div>
<?php endif; ?>

<div class="card">
  <div class="container">
    <div class="row">
      <div class="col-4">
        <div class="card-body">
          <div class="circle-view"></div><br>
          <h5 class="card-title">{{ $account[0]->name }}</h5>
          <h6 class="card-subtitle mb-2 text-muted">{{ '@' . $account[0]->username }}</h6><hr>
          <p class="card-text">{{ ucfirst($account[0]->role) }}</p>
        </div>
      </div>
      <div class="col-8">
        <div class="card-body">
          <h5 class="card-title">Account History</h5>
        </div>
        <table class="table table-hover">
          <thead>
            <tr>
              <th scope="col">Action</th>
              <th scope="col">Time/Date</th>
              <th scope="col">Attachment</th>
              <th scope="col">Status</th>
            </tr>
          </thead>
          <!-- <tbody>
            <tr>
              <th scope="row">Add File</th>
              <td>Saturday, 08:01pm</td>
              <td>
                <a href="#">View</a>
              </td>
              <td>
                <a href="#">Success</a>
              </td>
            </tr>
          </tbody> -->
        </table>
      </div>
    </div>
  </div>
</div>

@endsection


@section('scripts')
<script type="text/javascript">

  $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
  var username = '{!! $account[0]->username !!}';
  getLogs();

  function getLogs() {
    $.ajax({
      type: 'GET',
      url: '/accounts/logs',
      data: { 'username': username },
      success: function(response) {
        for (var i = 0; i < response.logs.length; i++) {
          $('.table').append(getRecordHTML(response.logs[i]));
        }
      },
      error: function(a, status, code) {
        console.log(status);
      }
    });
  }

  function getRecordHTML(log) {
    console.log(log);
    var output =
    "<tbody>"+
    "  <tr>"+
    "    <th scope=\"row\">Add File</th>"+
    "    <td>" + log.updated_at + "</td>"+
    "    <td>"+
    "      <a href=\"/files/view/" + log.id + "\">View</a>"+
    "    </td>"+
    "    <td>"+
    "      <a href=\"/files/view/" + log.id + "\">Success</a>"+
    "    </td>"+
    "  </tr>"+
    "</tbody>";
    return output;
  }

</script>
@endsection
