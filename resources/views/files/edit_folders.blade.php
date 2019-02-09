@extends('authentication.dashboard')

@section('header')
	<meta name="csrf-token" content="{{ csrf_token() }}">

	<style type="text/css">

		a:hover {
			text-decoration: none;
		}

		.title {
			text-align: center;
			margin-top: 20px;
		}

		.card {
		 	margin: auto;
		 	width: fit-content;
		 	margin-top: 40px;
		}

		th, td {
			text-align: center;
		}

		input {
			outline: none;
			border:	none;
			border-radius: 5px;
			background-color: #f5f5f5;
			padding: 0 10px;
			margin: auto 20px;
		}


		.add-folder {
			text-align: center;
			display: flex;
			flex-direction: center;
		}

		.button-link {
			cursor: pointer;
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

<h2 class="title">Manage Folders</h2>

<div class="card">
  <div class="card-body">
    <div style="text-align:center">
     	<!-- <h5 class="card-title">Folders</h5> -->
    </div>
    <table class="table table-hover">
      <thead>
        <tr>
	    	<th scope="col">Folder</th>
	    	<th scope="col">New Name</th>
	    	<th scope="col">Archive</th>
	    	<th scope="col">Changes</th>
        </tr>
      </thead>
      <tbody>
      	@foreach ($folders as $folder)

      		<tr>
	        	<td>{{ strtoupper($folder->name) }}</td>
	        	<td>
	        		<input type="text" id="input_folder_id_{{ $folder->id }}">
	        	</td>
	        	<td>
	        		@if ($folder->archived == 0)
	        			<button class="card-link btn btn-primary" data-id="{{ $folder->id }}" onclick="toggleArchive(this)">Archive</button>
	        		@else
	        			<button class="card-link btn btn-primary" data-id="{{ $folder->id }}" onclick="toggleArchive(this)">Unarchive</button>
	        		@endif
	        	</td>
	        	<td>
	        		<button class="card-link btn btn-primary" data-id="{{ $folder->id }}" onclick="changeName(this)">Submit</button>
	        	</td>
	        </td>

      	@endforeach
      </tr>
      </tbody>
    </table>
  </div>
</div>

<div class="card add-folder">
  <div class="card-body">
    <div style="text-align:center">
     	<h5 class="card-title">Add Folder</h5>
    </div>
    <input type="text" id="add_folder_name_input"><br><br>
    <button class="card-link btn btn-primary" onclick="addFolder(this)">Submit</button>
  </div>
</div>
<br><br>

@endsection

@section('scripts')
<script type="text/javascript">
	
	function toggleArchive(e) {
		let id = $(e).data('id');
		let data = {
			'id': id
		};

		$.ajax({
			type: 'POST',
			headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
			url: 'manage/toggle_archive',
			data: data,
			success: function(data) {
				console.log(data);
				location.reload();
			},
			error: function(jqXHR, status, error) {
		    	console.log(status + '\n' + error);
		    }
		});
	}

	function changeName(e) {
		let id = $(e).data('id');
		let new_name = $('#input_folder_id_' + id).val();
		let data = {
			'id': id,
			'new_name': new_name
		};

		$.ajax({
			type: 'POST',
			headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
			url: 'manage/update_name',
			data: data,
			success: function(data) {
				console.log(data);
				location.reload();
			},
			error: function(jqXHR, status, error) {
		    	console.log(status + '\n' + error);
		    }
		});
	}

	function addFolder(e) {
		let folder_name = $('#add_folder_name_input').val();
		let data = {
			'folder_name': folder_name
		};

		$.ajax({
			type: 'POST',
			headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
			url: 'manage/add',
			data: data,
			success: function(data) {
				console.log(data);
				location.reload();
			},
			error: function(jqXHR, status, error) {
		    	console.log(status + '\n' + error);
		    }
		});
	}

</script>
@endsection