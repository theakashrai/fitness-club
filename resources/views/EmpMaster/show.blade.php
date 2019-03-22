@extends('layouts.app')
@section('content')
<div class="row">

<div class="col-sm-6 col-centered">
<div class="card">
  <div class="card-header">
    Member Details  </div>
  <div class="card-body">
  <?php
  $joindt = new DateTime($emp->EmpJoinDate);
  $dobdt = new DateTime($emp->EmpDOB);
  $resigndt = new DateTime($emp->EmpResignDate);
  $today = new DateTime(date('d-M-Y'));
  $activeInterval = date_diff($today,$resigndt)->format('%a');
  ?>
  <table class="table profile-det">
  <tr>
  <td colspan="2" align="center"> <img  src="<?php echo asset("storage/uploads/$emp->EmpImgFilePath") ?>" style="border-radius: 50%;"></td>
  </tr>
  <tr><td>Name:</td><td>{{$emp->EmpName}}</td></tr>
  <tr><td>Mobile:</td><td>{{$emp->EmpPhNo}}</td></tr>
  <tr><td>Date of Birth:</td><td>{{$dobdt->format('d-M-Y')}}</td></tr>
  <tr><td>Join Date:</td><td>{{$joindt->format('d-M-Y')}}</td></tr>
  <tr><td>Plan Expiry Date:</td><td>{{$resigndt->format('d-M-Y')}}</td></tr>
  <tr><td>Address:</td><td>{{$emp->EmpAddress}}</td>
  <tr><td colspan="2">{{$activeInterval.' days remaining'}}</td></tr>
  </tr>
  
  </table>
  </div>
</div>
</div>

</div>
@endsection