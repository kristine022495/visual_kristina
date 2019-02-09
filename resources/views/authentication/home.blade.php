@extends('authentication.dashboard')

@section('header')
	<style type="text/css">
		textarea, input { outline: none; }

		.container {
			padding: 20px;
		}

		.title {
			text-align: center;
		}

		.search {
			width: 100%px;
			text-align: center;
		}

		.search-text {
			box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24);
			background-color: white;
			margin-left: auto;
			margin-right: auto;
			height: 50px;
		    width: 400px;
		    padding: 20px 20px;
		    font-size: 20px;
		}

		img {
		    height: 100px;
		    width: 300px;
	    }

	    .banner {
		    width: 100%;
		    display: flex;
		    justify-content: center;
		    align-items: center;
		    margin-top: 20px;
		    margin-bottom: 20px;
		}

		.main {
	      height: -webkit-fill-available;
	      background-image: url('/img/um-bg2.jpg');
	      background-size: cover;
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
	<div class="container">
		<div class="banner">
			<img src="https://i1.wp.com/umap.org/wp-content/uploads/2017/06/UM_Logo2.jpg">	
		</div>
		
		<h2 class="title">Welcome to <br> Quality Management System <br>for File Archives</h2>
		<br>
		<div class="search">
			<form method="post" action="/files/wildsearch">

				@csrf

				<input id="searchString" class="card search-text" name="search_string">
				<br>
				<button id="search" class="btn btn-primary active">Search</button>
			</form>
		</div>
	</div>
@endsection

@section('scripts')
<script type="text/javascript">

	$('#search').click(function (e) {
		
	});

</script>
@endsection