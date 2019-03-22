@extends('layouts.app')
@section('content')
<div class="row">

<div class="col-sm-6 col-centered">
<div class="card">
  <div class="card-header">
    Add Member
  </div>
  <div class="card-body">
    @if ($errors->any())
      <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
        </ul>
      </div><br />
      
    @endif
      <form method="post" action="{{ route('EmpMaster.store') }}" enctype="multipart/form-data">
      @csrf
        <div class="form-group">
        {!! Form::file('image',['class'=>'form-control','placeholder'=>'','accept'=>'image/*','capture'=>'true'])!!}
        </div>
          <div class="form-group">
              <label for="CompCode">Company</label>
              <select name ="CompCode" required>
              <option value=''>Choose..</option>
              @foreach($CompMaster as $option)
              <option value="{{$option->CompCode}}">{{$option->CompName}}</option>
              @endforeach  
              </select>
          </div>
          
          <div class="form-group">
              <label for="EmpName">Name</label>
              <input type="text" class="form-control"  name="EmpName" required/>
          </div>
          <div class="form-group">
              <label for="EmpAddress">Address</label>
              <input type="text" class="form-control"  name="EmpAddress" required/>
          </div>
          <div class="form-group">
              <label for="EmpPhNo">Mobile number</label>
              <input type="text" class="form-control" name="EmpPhNo" required/>
          </div>
          <div class="form-group">
              <label for="EmpDOB">Date of Birth</label>
              <input type="date" class="form-control" name="EmpDOB" required/>
          </div>
          <div class="form-group">
              <label for="EmpJoinDate">Joining Date</label>
              <input type="date" class="form-control" name="EmpJoinDate" required/>
          </div>
          <div class="form-group">
              <label for="addPlan">Plan</label>
              <select name ="addPlan" required>
              <option value=''>Choose..</option>
            <option value="1">
            Monthly
            </option>
            <option value="2">
            Quaterly
            </option>
            <option value="3">
            Half-Yearly
            </option>
            <option value="4">
            Yearly
            </option>
          </select>
          </div>
          <div class="form-group">
              <label for="EmpMarried">Martial Status</label>
              <select name ="EmpMarried" required>
              <option value=''>Choose..</option>
                <option value="2">Married</option>
                <option value="1">Un-Married</option>
              </select>
          </div>
          <div class="form-group">
              <label for="EmpEmail">Email ID</label>
              <input type="text" class="form-control" name="EmpEmail" required/>
          </div>
          <div class="form-group">
              <label for="ShiftGroupCode">Shift Group</label>
              <select name ="ShiftGroupCode" required>
              <option value=''>Choose..</option>
              @foreach($ShiftGroupMaster as $option)
              <option value="{{$option->ShiftGroupCode}}">{{$option->ShiftGroupName}}</option>
              @endforeach 
              </select>
              
          </div>
          <div class="form-group">
              <label for="ShiftCode">Shift</label>
              <select name ="ShiftCode" required>
              <option value=''>Choose..</option>
              @foreach($ShiftMaster as $option)
              <option value="{{$option->ShiftCode}}">{{$option->ShiftName}}</option>
              @endforeach 
              </select>
              
          </div>
          <div class="form-group">
              <label for="DeptCode">Department</label>
              <select name ="DeptCode" required>
              <option selected="true">Choose..</option>
              @foreach($DeptMaster as $option)
              <option value="{{$option->DeptCode}}">{{$option->DeptName}}</option>
              @endforeach 
              </select>
          </div>
          <div class="form-group">
              <label for="DesgCode">Designation</label>
              <select name ="DesgCode" required>
              <option value=''>Choose..</option>
              @foreach($DesgMaster as $option)
              <option value="{{$option->DesgCode}}">{{$option->DesgName}}</option>
              @endforeach 
              </select>
          </div>
          <div class="form-group">
              <input type="text" class="form-control" value="{{$ID}}" name="ID" required />
          </div>
          
          <button type="submit" class="btn btn-primary">Add</button>
      </form>
  </div>
</div>
</div>

</div>
@endsection