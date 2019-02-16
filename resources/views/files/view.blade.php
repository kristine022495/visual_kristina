@extends('authentication.dashboard')

@section('header')

  <style>

    h4 { color: #1c313a; }
    h6 { color: #b61827; }

    .view {
      padding: 20px;
    }

    .file {
      width: 300px;
      height: 400px;
      background-color: #718792;
      margin: 20px;
      margin-left: auto;
      margin-right: auto;
    }

    .card {
      box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24);
      transition: all 0.3s cubic-bezier(.25,.8,.25,1);
      background-color: black;
      height: 400px;
      width: 300px;
      margin-bottom: 20px;
    }

    .card:hover {
      box-shadow: 0 14px 28px rgba(0,0,0,0.25), 0 10px 10px rgba(0,0,0,0.22);
    }

    .preview {
      padding-left: 20px;
    }

    .icon {
      height: 50px;
      width: 50px;
      border-radius: 50%;
      background-color: #1c313a;
      color: white;
      margin-top: 10px;
      margin-bottom: 10px;
      text-align: center;
      padding-top: 14px;
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

  <div class="container-fluid view">
    <div class="row">
      <div class="col-4 details">
        <h1>{{ $fileset->name }}</h1><br>
        <?php if (isset($fileset->type)) : ?>
          <h4>Type</h4>
          <h6>{{ $fileset->type }}</h6><br>
        <?php endif; ?>
        <?php if ($fileset->school_year != null) : ?>
          <h4>School Year</h4>
          <h6>{{ $fileset->school_year }}</h6><br>
        <?php endif; ?>
        <?php if ($fileset->associated_id != null) : ?>
          <h4>Associated ID</h4>
          <h6>{{ $fileset->associated_id }}</h6><br>
        <?php endif; ?>
        <?php if ($fileset->department != null) : ?>
          <h4>Department</h4>
          <h6>{{ $fileset->department }}</h6><br>
        <?php endif; ?>
        <h4>Uploader</h4>
        <h6>{{ $fileset->uploader }}</h6><br>
      </div>
      <div class="col-8" id="files">
        <div class="row preview">
          <!-- <div class="col-4">
            <div class="icon">1</div>
            <a class="btn btn-primary active">Download</a>
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".preview-image-">Preview</button>
            <div class="modal fade preview-image" tabindex="-1" role="dialog" aria-hidden="true">
              <div class="modal-dialog modal-lg">
                <div class="modal-content">
                  <img height="1000px" width="700px"/>
                </div>
              </div>
            </div>
          </div>
          <div class="col-8">
            <div class="card"></div>
          </div> -->
        </div>

      </div>

    </div>
  </div>

@endsection

@section('scripts')
<script type="text/javascript">

  var files = {!! $fileset->files !!};
  console.log({!! $fileset !!});
  console.log(files);

  for (file in files) {
    var file = files[file];
    var compressedValue = file.value;
    var index = file.index;
    var height = file.height;
    var width = file.width;
    var image = deCompress(compressedValue, height, width);
    console.log('hello');
    $(image).css({
      'height': '400px',
      'width': '300px'
    });
    $(image).addClass('card');

    console.log(file);

    var preview =
    "<div class=\"row preview\">"+
    "  <div class=\"col-4\">"+
    "    <div class=\"icon\">" + index + "</div>"+
    "    <a href=\"" + image.src + "\" download=\"download\" class=\"btn btn-primary active\">Download</a><br>"+
    "    <button class=\"btn btn-primary\" onclick=\"print(" + file.id + ")\">Print</button>"+
    "    <button type=\"button\" class=\"btn btn-primary\" data-toggle=\"modal\" data-target=\".preview-image-" + index + "\">Preview</button>"+
    "    <div class=\"modal fade preview-image-" + index + "\" tabindex=\"-1\" role=\"dialog\" aria-hidden=\"true\">"+
    "      <div class=\"modal-dialog modal-lg\">"+
    "        <div class=\"modal-content\">"+
    "          <img height=\"1000px\" width=\"700px\" src=\"" + image.src + "\"/>"+
    "        </div>"+
    "      </div>"+
    "    </div>"+
    "  </div>"+
    "  <div class=\"col-8 image-" + index + "\">"+
    "    <img id=\"image_id_" + file.id + "\" src=\"" + image.src + "\" class=\"card\"/>"+
    "  </div>"+
    "</div>";

    $('#files').append(preview);
  }

  function print(image_id) {
    console.log('printing: ' + image_id + document.getElementById('image_id_' + image_id).src);
    // pwin = window.open(document.getElementById('image_id_' + image_id).src, 'Image');
    // pwin.onload = function () {
    //   window.print();
    // };
    popup = window.open();
    popup.document.write("<img height='842px' width='595px' src='" + document.getElementById('image_id_' + image_id).src + "'>");
    popup.print();
  };

  function deCompress(compressedData, height, width) {
    compressedData += 'L';
    var decompressed = '';
    var letter = '';
    var number = '';
    var singleChar = '';

    for (var i = 0; i < compressedData.length; i++) {

      if (!isNaN(compressedData[i])) {
        number += compressedData[i];
      } else {
        if (number == '') {
          letter = compressedData[i];
          if (singleChar != '') {
            decompressed += singleChar;
          }
        }
        if (number != '') {
          decompressed += letter.repeat(parseInt(number));
          letter = compressedData[i];
          number = '';
          singleChar = letter;
        }
      }

    }

    var stringSet = decompressed.slice(1);

    /*
      length = decompressedData * 4
      should return Uint8ClampedArray
      COLOR CODE
      A=1 B=50 C=100 D=150 W=255
    */

    var buffer = new Uint8ClampedArray(width * height * 4);
    var index = 0;

    for (var y = 0; y < height; y++) {
      for (var x = 0; x < width; x++) {
        var pos = (y * width + x) * 4;
        var pixel = stringSet[index];
        var letter = pixel == 'A' ? 1
                    : pixel == 'B' ? 50
                    : pixel == 'C' ? 100
                    : pixel == 'D' ? 150
                    : pixel == 'W' ? 255 : 0;
        buffer[pos]		= letter;
        buffer[pos+1] = letter;
        buffer[pos+2] = letter;
        buffer[pos+3] = 255;
        index++;
      }
    }

    var canvas = document.createElement('canvas');
    var ctx = canvas.getContext('2d');

    canvas.width = width-4;
    canvas.height = height;

    var idata = ctx.createImageData(width, height);

    idata.data.set(buffer);

    ctx.putImageData(idata, 0, 0);

    $(canvas).css('height', '500px');
    $(canvas).css('width', '500px');

    var image = new Image();
    image.src = canvas.toDataURL('image/jpeg', 1.0);
    console.log(image.src);

    return image;
  }

</script>
@endsection
