@extends('layouts.app')
@section('content')
<div class="row">

    <div class="col-sm-6 col-centered">
        <div class="card">
            <div class="card-header">
                Search Details
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
                <form method="get" action="{{ route('searchResults') }}">
                    @csrf

                    <div class="form-group">
                        <label for="EmpName">Name</label>
                        <input type="text" class="form-control" name="EmpName" />
                    </div>

                    <div class="form-group">
                        <label for="EmpAddress">Address</label>
                        <input type="text" class="form-control" name="EmpAddress" />
                    </div>

                    <div class="form-group">
                        <label for="EmpPhNo">Mobile number</label>
                        <input type="text" class="form-control" name="EmpPhNo" />
                    </div>

                    <div class="form-group">
                        <label for="EmpEmail">Email ID</label>
                        <input type="text" class="form-control" name="EmpEmail" />
                    </div>
                    <div class="form-group">
                            <label for="EmpJoinDate">Date of Joining</label>
                            <input type="date" class="form-control" name="EmpJoinDate"/>
                        </div>
                    <div class="form-group">
                        <label for="DesgCode">Designation</label>
                        <select name="DesgCode">
                            <option value='' selected="true">Choose..</option>
                            @foreach($DesgMaster as $option)
                            <option value="{{$option->DesgCode}}">{{$option->DesgName}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="ID">ID</label>
                        <input type="text" class="form-control" name="ID" />
                    </div>
                    
                    <div class="form-group">
                            <label for="dtDiff">Plan Validity</label>
                            <input type="text" class="form-control" name="dtDiff" />
                    </div>

                    <button type="submit" class="btn btn-primary">Search</button>
                </form>
            </div>
        </div>
    </div>

</div>
@endsection 