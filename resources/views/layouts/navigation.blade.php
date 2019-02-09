<!-- Navigation -->
<div class="filler" style="height:60px"></div>

<?php if(!Auth::check()) : ?>
  <div class="row header-bar z-depth-1 secondary-text-color align-items-center" style="text-align: center;">
    <div class="col">Quality Management Office</div>
  </div>
<?php else : ?>
  <div class="row header-bar z-depth-1 secondary-text-color align-items-center">
    <div class="col">Quality Management Office</div>
    <div class="col-5"></div>
    <div class="col-2 text-right">{{Auth::user()->name}}</div>
    <a href="/logout" class="btn btn-primary" style="margin-top:6px;color:#ffcdd2">Logout</a>
  </div>
<?php endif; ?>
