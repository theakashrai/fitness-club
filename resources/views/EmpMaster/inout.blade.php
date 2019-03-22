@extends('layouts.app')
  @section('content')


<div class="row">
    <div class="col-sm col-centered">
    
        <div>
            <h2>Inout Details for <?php echo $reqDate ;?> </h2>
        </div>
        @if(session()->get('success'))
        <div class="alert alert-success">
            {{ session()->get('success') }}
        </div>
        <br /> 
        @endif
        <div>
        <form method="POST" action="{{ route('inoutByDate')}}" >
        @csrf
            <input name="inoutDate" type="date"/>
            <input type="submit">
        </form>
        </div>
        @if(sizeof($inOutData)==0)
            No records to display
            @endif
        @if (sizeof($inOutData)>0) 
        <div class="table-responsive">
        <table class="table table-hover">
            <thead class="thead-dark">
                <tr>
                    <th>Duration</th>
                   
                    <th>Member</th>
                </tr>
            </thead>
            
           
            @foreach($inOutData as $data)
            <tr>
            <td>{{$data->hours. ' hours '. $data->minutes.' minutes'}}</td>
           
            <td>{{$data->EmpName}}</td>
            <tr>
            @endforeach
          
            </table>
        </div>
            @endif
  </div>
  
</div>

@endsection