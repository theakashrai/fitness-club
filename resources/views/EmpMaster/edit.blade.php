@extends('layouts.app')

@section('content')
<div class="col-sm-6 col-centered">
    <div class="card">
        <div class="card-header">
            Edit Member
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
            <form method="post" action="{{ route('EmpMaster.update', $emp) }}" enctype="multipart/form-data">
                @method('PATCH')
                @csrf
                <div class="form-group">
                {!! Form::file('image',['class'=>'form-control','placeholder'=>'','accept'=>'image/*','capture'=>'true'])!!}
                </div>
                <div class="form-group">
                    <label for="EmpName">Name:</label>
                    <input type="text" class="form-control" name="EmpName" value="{{ $emp->EmpName }}" required />
                </div>
                <div class="form-group">
                    <label for="EmpPhNo">Mobile Number</label>
                    <input type="text" class="form-control" name="EmpPhNo" value="{{ $emp->EmpPhNo }}" required />
                </div>
                <div class="form-group">
                    <label for="EmpDOB">Date of Birth</label>
                    <input type="text" class="form-control" name="EmpDOB" value="{{ $emp->EmpDOB }}" required />
                </div>

                <div class="form-group">
                    <label for="addPlan">Add Plan</label>
                    <select name="addPlan">
                        <option selected="true" value="0">
                            Choose..
                        </option>
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
                    <label for="EmpEmail">E-mail</label>
                    <input type="text" class="form-control" name="EmpEmail" value="{{ $emp->EmpEmail }}" required />
                </div>
                <div class="form-group">
                    <label for="EmpAddress">Address</label>
                    <input type="text" class="form-control" name="EmpAddress" value="{{ $emp->EmpAddress }}" required />
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>
</div>

@endsection 