@extends('authentication.dashboard')

@section('header')

  <meta name="csrf-token" content="{{ csrf_token() }}">

  <style>

    textarea, input { outline: none; }

    .card {
      box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24);
      transition: all 0.3s cubic-bezier(.25,.8,.25,1);
      background-color: white;
    }

    .content-fluid {
      padding: 20px;
    }

    .search {
      width: 400px;
    }

    .search-text {
      height: 50px;
      width: 100%;
      padding: 20px 20px;
      font-size: 20px;
    }

    .search-field {
      padding: 20px;
    }

    .result {
      padding: 20px;
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

  <div class="content-fluid field">
    <div class="row">
      <div class="col">
        <div class="search">
          <h3 style="text-align:center">Search</h3>
          @if (!empty($search) > 0)
            <input id="searchString" class="card search-text" value="{{$search}}">
          @else
            <input id="searchString" class="card search-text" value="">
          @endif
          
        </input><br>
          <div class="card search-field">
            <form>
              <div class="form-group">
                <label for="inputType">Type</label>
                <input type="text" class="form-control" id="inputType">
              </div>
              <div class="form-group">
                <label for="inputSchoolYear">School Year</label>
                <input type="text" class="form-control" id="inputSchoolYear">
              </div>
              <div class="form-group">
                <label for="inputAssociatedID">Associated ID</label>
                <input type="text" class="form-control" id="inputAssociatedID">
              </div>
              <div class="form-group">
                <label for="inputUploader">Uploader</label>
                <input type="text" class="form-control" id="inputUploader">
                <small class="form-text text-muted">Indicate the username for the uploader</small>
              </div>
              <div class="form-group">
                <label for="inputDepartment">Department</label>
                <input type="text" class="form-control" id="inputDepartment">
              </div>
              <button type="submit" id="search" class="btn btn-primary active">Search</button>
            </form>
          </div>
        </div>
      </div>
      <div class="col results">
        <h3>Results</h3>
        <!-- <div class="result">
          <h5>Lorem Ipsum Dolor Sit Amet</h5>
          <small>Type: <b>Calendar</b></small>
          <small>School Year: <b>2018-2019</b></small><br>
          <small>Associated ID: <b>391482</b></small>
          <small>Department: <b>CCE</b></small><br>
          <small>Uploader: <b>@administrator</b></small>
          <br><br><button class="btn btn-primary active">View</button>
        </div>
        <div class="result">
          <h5>Lorem Ipsum Dolor Sit Amet</h5>
          <small>Type: <b>Calendar</b></small>
          <small>School Year: <b>2018-2019</b></small><br>
          <small>Associated ID: <b>391482</b></small>
          <small>Department: <b>CCE</b></small><br>
          <small>Uploader: <b>@administrator</b></small>
          <br><br><button class="btn btn-primary active">View</button>
        </div>
        <div class="result">
          <h5>Lorem Ipsum Dolor Sit Amet</h5>
          <small>Type: <b>Calendar</b></small>
          <small>School Year: <b>2018-2019</b></small><br>
          <small>Associated ID: <b>391482</b></small>
          <small>Department: <b>CCE</b></small><br>
          <small>Uploader: <b>@administrator</b></small>
          <br><br><button class="btn btn-primary active">View</button>
        </div> -->
      </div>
    </div>
  </div>

@endsection


@section('scripts')
<script type="text/javascript">

  $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
  let wild_search_string = '';
  var search = {};

  function runSearch() {
    getSearchValues();
    $.ajax({
      type: 'POST',
      url: '/files/search',
      data: search,
      success: function(results) {
        displayResults(results.results);
      },
      error: function(jqXHR, status, error) {
        console.log(status + '\n' + error);
      }
    });
  }

  $(this).ready(function() {
    // console.log($('#searchString')[0].value);
    // wild_search_string = $('#searchString')[0].value;

    // if (wild_search_string != '') {
    //   console.log('there is a search');

    // } else {
    //   console.log('there is no search');
    // }
    runSearch();
  });

  $('#search').click(function(e){
    e.preventDefault();
    runSearch();
  });

  function displayResults(results) {
    for (var i = 0; i < results.priority.length; i++) {
      $('.results').append(getResultHMTL(results.priority[i]));
    }
    for (var i = 0; i < results.additional.length; i++) {
      $('.results').append(getResultHMTL(results.additional[i]));
    }
  }

  function getResultHMTL(result) {
    var output = document.createElement('div');
    $(output).addClass('result');
    $(output).append("<h5>" + result.name + "</h5>");
    if (result.type != null) {
      $(output).append("<small>Type: <b>" + result.type + "</b> </small>")
    }
    if (result.school_year != null) {
      $(output).append("<small>School Year: <b>" + result.school_year + "</b> </small><br>")
    }
    if (result.associated_id != null) {
      $(output).append("<small>Associated ID: <b>" + result.associated_id + "</b> </small>")
    }
    if (result.department != null) {
      $(output).append("<small>Department: <b>" + result.department + "</b> </small><br>")
    }
    if (result.uploader != null) {
      $(output).append("<small>Uploader: <b>" + result.uploader + "</b> </small><br><br>")
    }
    $(output).append("<a class=\"btn btn-primary active\" href=\"/files/view/" + result.id + "\">View<a/>");
    return output;
  }

  function getSearchValues() {
    var main =          $('#searchString').val();
    var type =          $('#inputType').val();
    var school_year =   $('#inputSchoolYear').val();
    var uploader =      $('#inputUploader').val();
    var department =    $('#inputDepartment').val();
    search = {
      'main': main,
      'type': type,
      'school_year': school_year,
      'uploader': uploader,
      'department': department
    };
  }

</script>
@endsection
