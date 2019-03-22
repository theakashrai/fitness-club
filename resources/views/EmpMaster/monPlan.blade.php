@extends('layouts.app')
  @section('content')


<div class="row">
    <div class="col-sm col-centered">
        <div style="padding-left:20px">
            <h2>Member's Plan Exipring this month</h2>
        </div>
        @if(session()->get('success'))
        <div class="alert alert-success">
            {{ session()->get('success') }}
        </div>
        <br /> 
        @endif
        <table class="table table-hover">
            <thead class="thead-dark">
                <tr>
                    <th colspan="2">Plan</th>
                    <th style="white-space:nowrap;">Name</th>
                    <th style="white-space:nowrap;">Phone Number</th>
                    <th style="white-space:nowrap;">Date of Birth</th>
                    <th style="white-space:nowrap;">Date of Joining</th>
                    
                    <th style="white-space:nowrap;">Email</th>
                    <th style="white-space:nowrap;">Address</th>
                    <th style="white-space:nowrap;">PunchID</th>

                    <th colspan="2">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($emp as $employee)
                <?php 
        $joindt = new DateTime($employee->EmpJoinDate);
        $plandt = new DateTime($employee->EmpResignDate);
        //$date =new Carbon ('last day of this month');
        $today = new DateTime(date('d-F-Y')); 
        $interval = date_diff($joindt,$plandt)->format('%a');
        $activeInterval = date_diff($today,$plandt)->format('%a');

        if(date_diff($today,$plandt)->format('%R') == '+' ){
        $isActive= 'Active';
        $bgcolor = '#00FF00';
        $st = 'to go';
        }
        else{
        $isActive ='Inactive';
        $bgcolor = '#FF0000';
        $st = 'ago';
        }

         ?>
                    <tr>
                        <td bgcolor='<?php echo $bgcolor; ?>'>{{$isActive}}</td>
                        <td style="white-space:nowrap;">{{$activeInterval.' days '.$st}}</td>
                        <td>{{$employee->EmpName}}</td>
                        <td style="white-space:nowrap;">{{$employee->EmpPhNo}}</td>
                        <td >{{date('d-m-Y', strtotime($employee->EmpDOB))}}</td>
                        <td>{{$joindt->format('d-m-Y')}}</td>
                        
                        <td>{{$employee->EmpEmail}}</td>
                        <td style="overflow:auto">{{$employee->EmpAddress}}</td>
                        <td>{{$employee->EmpPunchID}}</td>
                        <td><a href="{{ route('EmpMaster.edit',$employee->EmpID)}}" class="btn btn-primary">Edit</a></td>
                        <td>
                            <form action="{{ route('EmpMaster.destroy', $employee->EmpID)}}" method="post">
                                @csrf @method('DELETE')
                                <button class="btn btn-danger" type="submit">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
            </tbody>
            </table>
  </div>
</div>

@endsection