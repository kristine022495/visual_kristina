@extends('authentication.dashboard')

@section('header')

<meta name="csrf-token" content="{{ csrf_token() }}">

<style media="screen">

  .container {
    height: -webkit-fill-available;
    padding: 20px;
  }

  a.card-link.btn.btn-primary.active {
    background-color: #ef5350;
    border-color: #ef5350;
  }

  a.card-link.btn.btn-primary.active:hover {
    color: #b61827;
  }

  .btn-primary.dropdown-toggle {
    background-color: #ef5350;
    color: #ef5350;
  }

  .attributes {
    padding: 0px;
    height: 100%;
    padding-right: 20px;
    position: sticky;
    top: 20px;
  }

  .btn-primary {
    font-size: 10px;
  }

  .chip {
    display: inline-block;
    padding: 0 10px;
    height: 30px;
    font-size: 12px;
    line-height: 30px;
    border-radius: 25px;
    background-color: #ff867c;
    margin-top: 6px;
    color: white;
    margin-right: 5px;
  }

  .closebtn {
    padding-left: 10px;
    color: white;
    font-weight: bold;
    float: right;
    font-size: 20px;
    cursor: pointer;
  }

  .closebtn:hover {
    color: #b61827;
  }

  .card-text {
    color: #b61827;
  }

  .details h5 {
    color: #718792;
  }

  .details p {
    color: #1c313a;
  }

  .image {
    background-color: white;
    height: 400px;
    width: 300px;
    float: right;
  }

  .icon {
    height: 50px;
    width: 50px;
    background-color: #455a64;
    border-radius: 50%;
    color: white;
    font-size: 20px;
    padding-top: 11px;
    text-align: center;
  }

  .fileContainer {
    overflow: hidden;
    position: relative;
    float: left;
  }

  .fileContainer [type=file] {
    cursor: inherit;
    display: block;
    font-size: 999px;
    filter: alpha(opacity=0);
    min-height: 100%;
    min-width: 100%;
    opacity: 0;
    position: absolute;
    right: 0;
    text-align: right;
    top: 0;
  }

  .toast {
    margin-bottom: 20px;
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
  <div class="row">
    <div class="card attributes col-4">
      <div class="card-body">
        <h5 class="card-title">Upload A File</h5><hr>
        <!-- <a href="#" class="card-link btn btn-primary active">Select Files</a> -->
        <div class="fileContainer">
          <a href="#" class="card-link btn btn-primary active">Select Files</a>
          <input type="file" id="chooseFile" accept=".png, .jpg, .jpeg" multiple>
        </div>
        <br><br><br>
        <div id="attributes">
          <div class="form-group">
            <h6 class="card-subtitle mb-2 text-muted">Folder</h6>
            <select class="form-control" id="folder" name="folder">
              @foreach ($folders as $folder)
                <option value="{{ $folder->id }}">{{ strtoupper($folder->name) }}</option>
              @endforeach
            </select>
          </div>

          <div class="form-group">
            <h6 class="card-subtitle mb-2 text-muted">Sub Folder</h6>
            <input type="text" id="subFolders" class="form-control" name="sub_folder" required list="file_sets" autocomplete="off"><br>
            <datalist id="file_sets"></datalist>
          </div><br>

          <h6 class="card-subtitle mb-2 text-muted">Uploader</h6>
          <p class="card-text">{{'@'.Auth::user()->username }}</p><br>
          <input type="text" class="form-control" name="uploader" value="{{Auth::user()->username}}" hidden>
          <h6 class="card-subtitle mb-2 text-muted">Files Selected</h6>
          <div class="chips">
            <!-- Example Chip -->
            <!-- <div class="chip">
              File Example.png
              <span class="closebtn" onclick="this.parentElement.style.display='none'">&times;</span>
            </div> -->
          </div><br><br>
          <h6 class="card-subtitle mb-2 text-muted">School Year (Optional)</h6>
          <input id="school_year" type="text" class="form-control" name="school_year" required><br><br>
          <h6 class="card-subtitle mb-2 text-muted">File Type (Optional)</h6>
          <input id="file_type" type="text" class="form-control" name="file_type" required><br><br>
          <h6 class="card-subtitle mb-2 text-muted">Department (Optional)</h6>
          <input id="department" type="text" class="form-control" name="department" required><br><br>
          <h6 class="card-subtitle mb-2 text-muted">Associated ID (Optional)</h6>
          <input id="associated_id" type="text" class="form-control" name="associated_id" required><br>
          <button id="upload" class="card-link btn btn-primary active" style="margin-left: 8px;">Begin Upload</button>

          <!-- Compressed Variables -->
          <div id="compressedValues">
            <input name="" value="" hidden>
          </div>

        </div>
      </div>
    </div>

    <div class="file-preview col-7">
      <h3 style="text-align:center;color:#455a64" id="filePreviewTitle">File Preview</h3>
      <div class="container file-preview-container">
        <div class="progress">
          <div class="progress-bar" id="progressBar" role="progressbar" style="width: 0%" aria-valuemin="0" aria-valuemax="100"></div>
        </div> <br>
        <div id="filePreviewContainer">

        <!-- <div class="row">
          <div class="details col-4">
            <div class="icon">1</div><br>
            <h5>File Name</h5>
            <p>Example.png</p>
            <h5>Size</h5>
            <p>1.28 MB</p>
            <span class="bmd-form-group is-filled">
              <div class="checkbox">
                  <label>
                    <input type="checkbox" onclick="toggleImproveClarity(this)" checked="" data-id="1">
                    <span class="checkbox-decorator"><span class="check"></span></span> Improve Clarity
                  </label>
              </div>
            </span>
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".preview-image-1">Preview</button>
            <div class="modal fade preview-image-1" tabindex="-1" role="dialog" aria-hidden="true">
              <div class="modal-dialog modal-sm">
                <div class="modal-content">
                  <h2>Hello There</h2>
                </div>
              </div>
            </div>
          </div>
          <div class="col-8" id="export_1">
          </div>
        </div><br> -->

        </div>
      </div>
    </div>
  </div>
</div>

@endsection

@section('scripts')
<script type="text/javascript">

  var files = {};
  var input = document.querySelector('#chooseFile');
  var progress = 0;

  var folder = document.getElementById('folder');
  getSubFolders(folder.options[folder.selectedIndex].value);

  input.addEventListener('change', getImage);
  $('#upload').on('click', function(e) {
    e.preventDefault();
    upload();
  });

  $('#folder').change(function (e) {
    $('#file_sets').empty();
    selectedIndex = e.target.selectedIndex;
    folder_id = e.target.options[selectedIndex].value;

    getSubFolders(folder_id);
  });

  $('#subFolders').change(function (e) {

    sub_folder_name = e.target.value;

    $.ajax({
      type: 'GET',
      headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
      url: 'folders/getSubFolderDetails/',
      data: {
        'sub_folder_name': sub_folder_name,
        'folder_id': $('select[name=folder]').val()
      },
      success: function(data) {
        console.log(data);
        if (data.response.record_exists == 'true') {
          record = data.response.data;
          $('#school_year').val(record.school_year);
          $('#file_type').val(record.type);
          $('#department').val(record.department);
          $('#associated_id').val(record.associated_id);
        } else {
          $('#school_year').val('');
          $('#file_type').val('');
          $('#department').val('');
          $('#associated_id').val('');
        }
      },
      error: function(jqXHR, status, error) {
        console.log(status + '\n' + error);
      }
    });

  });

  function getSubFolders(folder_id) {
    data = {
      'folder_id': folder_id
    };

    $.ajax({
      type: 'GET',
      headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
      url: 'folders/getlist',
      data: data,
      success: function(data) {
        data.response.forEach(function(sub_folder) {
          $('#file_sets').append(
          '<option>' + sub_folder.name + '<option>'
          );
        });
      },
      error: function(jqXHR, status, error) {
        console.log(status + '\n' + error);
      }
    });
  }

  function upload() {
    $.snackbar({
      content: "Uploading file/s, please wait.", // text of the snackbar
      style: "toast", // add a custom class to your snackbar
      timeout: 4000, // time in milliseconds after the snackbar autohides, 0 is disabled
      htmlAllowed: true // allows HTML as content value
    });

    var uploadData = {
      'uploader':       $('input[name=uploader]').val(),
      'school_year':    $('input[name=school_year]').val(),
      'file_type':      $('input[name=file_type]').val(),
      'department':     $('input[name=department]').val(),
      'associated_id':  $('input[name=associated_id]').val(),
      'folder':         $('select[name=folder]').val(),
      'file_set':       $('input[name=sub_folder]').val(),
      'files':          []

    };

    for (file in files) {
      file = files[file];
      uploadData.files.push({
        'index':  file.index,
        'value':  file.value,
        'height': file.height,
        'width':  file.width
      });
    };

    $.ajax({
      type: 'POST',
      headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
      url: '/files/upload',
      data: uploadData,
      success: function(data) {
        var id = data.id;
        window.location.href = '/files/view/' + id;
      },
      error: function(jqXHR, status, error) {
        console.log(status + '\n' + error);
      }
    });
  }

  function updateProgress(number) {
    if (number != 0) {
      var update = number / input.files.length;
      progress += update;
      $('#progressBar').css('width', progress + '%');
    } else {
      $('#progressBar').css('width', '0%');
    }
  }

  function resetFiles() {
    $('#filePreviewContainer').empty();
    file = {};
    $('.chips').empty();
  }

  function getImage() {
    resetFiles();
    for (let i = 0; i < input.files.length; i++) {
      let img = new Image();
      let file = input.files[i];
      let fr = new FileReader();
      updateProgress(20);

      var chip = "<div class=\"chip\"> " + file.name +
          "<span class=\"closebtn\" data-id=\"" + i + "\" onclick=\"removeChip(this);\">&times;</span>" +
          "</div>";

      $('.chips').append(chip);
      updateProgress(40);

      fr.onload = function() {
        img.onload = function() {
          files[i] = {
            'name' : file.name,
            'size' : file.size,
            'image': img.src,
            'width': img.width,
            'height': img.height,
            'index': i,
            'value': ''
          }

          var preview = "<div class=\"row\">" +
            "<div class=\"details col-4\">" +
            "<div class=\"icon\">" + (parseInt(i)+1) + "</div><br>" +
            "<h5>File Name</h5>" +
            "<p>" + file.name + "</p>" +
            "<h5>Size</h5>" +
            "<p>" + (parseInt(file.size)/1000000) + " MB</p>" +
            "<div class=\"checkbox\">" +
            "<span class=\"bmd-form-group is-filled\">" +
            "<label>" +
            "<input type=\"checkbox\" onclick=\"toggleImproveClarity(this)\" checked data-id=\"" + i + "\">" +
            "<span class=\"checkbox-decorator\"><span class=\"check\"></span></span> Improve Clarity" +
            "</label>" +
            "</span>" +
            "<button type=\"button\" class=\"btn btn-primary\" data-toggle=\"modal\" data-target=\".preview-image-" + i + "\">Preview</button>"+
            "<div class=\"modal fade preview-image-" + i + "\" tabindex=\"-1\" role=\"dialog\" aria-hidden=\"true\">"+
            "<div class=\"modal-dialog modal-lg\">"+
            "<div class=\"modal-content\" id=\"export_preview_" + i + "\">"+
            "<h2>You have pressed: " + i + "</h2>"+
            "</div>"+
            "</div>"+
            "</div>"+
            "</div>" +
            "</div>" +
            "<div class=\"col-8\" id=\"export_" + i + "\">" +
            "<image style=\"height:400px;width:300px;\" src=\"" + img.src + "\">" +
            "</div>" +
            "</div><br>";
            updateProgress(20);

          $('#filePreviewContainer').append(preview);
          improveImage(i);
          updateProgress(20);
        };
        img.src = fr.result;
      };
      fr.readAsDataURL(file);
    }
    $.snackbar({
      content: "Files are ready for preview", // text of the snackbar
      style: "toast", // add a custom class to your snackbar
      timeout: 5000, // time in milliseconds after the snackbar autohides, 0 is disabled
      htmlAllowed: true // allows HTML as content value
    });
  }

  function compress(imageData) {
    /*
     COLOR CODE
     A=1 B=50 C=100 D=150 W=255
    */
    var data = imageData.data;
    var set = '';

    for (var y = 0; y < imageData.height; y++) {
      for (var x = 0; x < imageData.width; x++) {
        var pos = (y * imageData.width + x) * 4;
        switch (data[pos]) {
          case 1: set+= 'A'; break;
          case 50: set+= 'B'; break;
          case 100: set+= 'C'; break;
          case 150: set+= 'D'; break;
          case 255: set+= 'W'; break;
          default:break;
        }
      }
    }

    var compressedData = '';
    var temp = '';
    var currentPixel;
    temp += set.charAt(0);

    for (var i = 1; i < set.length; i++) {
      currentPixel = set[i];

      if (currentPixel == temp[0]) {
        temp += currentPixel;
      } else {
        compressedData += temp.length > 1
                        ? temp[0] + temp.length
                        : temp[0];
        temp = '' + currentPixel;
      }

    }
    compressedData += temp.length > 1
                    ? temp[0] + temp.length
                    : temp[0];

    return compressedData;
  }

  function removeChip(identifier) {
    var id = $(identifier).data('id');
    $(identifier).parent().remove();
    delete files[id];
    runPreview();
  }

  function runPreview() {
    $('.file-preview-container').empty();

    console.log(files);

    for (var item in files) {
      console.log(files[item]);
      var preview = "<div class=\"row\">" +
        "<div class=\"details col-4\">" +
        "<div class=\"icon\">" + (parseInt(item)+1) + "</div><br>" +
        "<h5>File Name</h5>" +
        "<p>" + files[item].name + "</p>" +
        "<h5>Size</h5>" +
        "<p>" + (parseInt(files[item].size)/1000) + " MB</p>" +
        "<div class=\"checkbox\">" +
        "<label>" +
        "<input type=\"checkbox\" onclick=\"toggleImproveClarity(this)\" checked data-id=\"" + files[item].index + "\"> Improve Clarity" +
        "</label>" +
        "</div>" +
        "</div>" +
        "<div class=\"col-8\" id=\"export_" + files[item].index + "\">" +
        "<image style=\"height:400px;width:300px;\" src=\"" + files[item].image + "\">" +
        "</div>" +
        "</div><br>";

      $('.file-preview-container').append(preview);
    }
  }

  function toggleImproveClarity(target) {
    var checked = target.checked;
    var id = $(target).data('id');
    if (checked) {
      improveImage(id);
    } else {
      var image = new Image();
      image.height = 400;
      image.width = 300;
      image.src = files[id].image;
      $('#export_' + id).empty();
      $('#export_' + id).append(image);

      var preview = new Image();
      preview.height = 1000;
      preview.width = 700;
      preview.src = files[id].image;;
      $('#export_preview_' + id).empty();
      $('#export_preview_' + id).append(preview);
    }
  }

  function improveImage(imageID) {
    var img = new Image();
    var canvas = document.createElement('canvas');
    img.src = files[imageID].image;
    canvas.width = files[imageID].width;
    canvas.height = files[imageID].height;
    canvas.style.cssText = "height: 400px; width: 300px;";
    ctx = canvas.getContext('2d');
    ctx.drawImage(img, 0, 0);
    var imageData = ctx.getImageData(0, 0, canvas.width, canvas.height);
    improveClarity(ctx, imageData);
    // removeDots(ctx, imageData);
    $('#export_' + imageID).empty();
    $('#export_' + imageID).append(canvas);

    files[imageID].value = compress(imageData);

    var preview = document.createElement('canvas');
    preview.width = files[imageID].width;
    preview.height = files[imageID].height;
    preview.style.cssText = "height: " + 1000 + "px; width: " + 700 + "px;";
    var preview_ctx = preview.getContext('2d');
    preview_ctx.drawImage(img, 0, 0);
    var preview_imageData = ctx.getImageData(0, 0, canvas.width, canvas.height);
    improveClarity(preview_ctx, preview_imageData);
    improveClarity(preview_ctx, preview_imageData);
    improveClarity(preview_ctx, preview_imageData);
    removeDots(preview_ctx, preview_imageData);
    removeDots(preview_ctx, preview_imageData);
    removeDots(preview_ctx, preview_imageData);
    $('#export_preview_' + imageID).empty();
    $('#export_preview_' + imageID).append(preview);
  }

  function improveClarity(ctx, imageData) {
    var data = imageData.data;
    for (var i = 0; i < 3; i++) {
      for (var i = 0; i < data.length; i += 4) {
        var median = data[i] <= 50 ? 1 // A
        : data[i] <= 100 ? 50 // B
        : data[i] <= 150 ? 100 // C
        : data[i] <= 200 ? 150 // D
        : 255; //W
        data[i]     = median;
        data[i + 1] = median;
        data[i + 2] = median;
      }
    }
    ctx.putImageData(imageData, 0, 0);
  }

  function removeDots(ctx, imageData) {
    var data = imageData.data;

    var prevSet = [];
    var set = [];
    var currentPixel = data[0];
    set.push(currentPixel)
    prevSet = set;

    for (var i = 8; i < data.length; i += 4) {

      currentPixel = data[i];

      if (currentPixel == set[0]) {
        set.push(currentPixel);
      } else if (currentPixel != set[0]) {
        if (set.length < 1) {
          var index = i - (set.length*4);
          for (var count = 0; count < set.length; count++) {
            data[index] = prevSet[0];
            data[index + 1] = prevSet[0];
            data[index + 2] = prevSet[0];
            index += 4;
          }
          prevSet = set;
          set = [];
          set.push(currentPixel);
        } else {
          prevSet = set;
          set = [];
          set.push(currentPixel);
        }
      } else {
        prevSet = set;
        set = [];
        set.push(currentPixel);
      }
    }
    ctx.putImageData(imageData, 0, 0);
  }

  function convertToGreyScale(ctx, imageData) {
    var data = imageData.data;
    for (var i = 0; i < data.length; i += 4) {
      var avg = (data[i] + data[i + 1] + data[i + 2]) / 3;
      data[i]     = avg;
      data[i + 1] = avg;
      data[i + 2] = avg;
    }
    ctx.putImageData(imageData, 0, 0);
  }

</script>
@endsection
