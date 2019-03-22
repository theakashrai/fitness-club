<?php

namespace App\Http\Controllers;

use App\EmpMaster;
use Illuminate\Http\Request;
use DateTime;
use DateInterval;
use Carbon\Carbon;
use DB;
use Intervention\Image\Facades\Image as Image;


class EmployeeController extends Controller
{

  public function __construct()
  {
    $this->middleware('auth');
  }

  /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
  public function index(Request $request)
  {
    $request->user()->authorizeRoles(['manager']);
    $employees = EmpMaster::simplePaginate(10);

    return view('EmpMaster.index', compact('employees'));
  }

  /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
  public function create(Request $request)
  {
    $request->user()->authorizeRoles(['manager']);
    $CompMaster = DB::table('CompMaster')->get();
    $DeptMaster = DB::table('DeptMaster')->get();
    $DesgMaster = DB::table('DesgMaster')->get();
    $ShiftGroupMaster = DB::table('ShiftGroupMaster')->get();
    $ShiftMaster = DB::table('ShiftMaster')->get();
    $EmpMasterIDS = DB::table('EmpMaster')
      ->selectRaw('max(EmpCode) as ec, max(convert(INT,EmpID)) as ei, max(convert(INT,EmpPunchID)) as ep')
      ->get();
    //error_log($EmpMasterIDS);
    $EmpCode = $EmpMasterIDS[0]->ec;
    $EmpID = $EmpMasterIDS[0]->ei;
    $EmpPunchID = $EmpMasterIDS[0]->ep;
    $ID = max(array($EmpCode, $EmpID, $EmpPunchID)) + 1;
    //error_log($ID);


    return view('EmpMaster.create')->with(compact('CompMaster', 'DeptMaster', 'DesgMaster', 'ShiftGroupMaster', 'ShiftMaster', 'ID'));
  }

  /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
  public function store(Request $request)
  {
    $this->validate($request, array(

      'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    ));

    $emp = new EmpMaster;

    $emp->EmpID = $request->get('ID');
    $emp->CompCode = $request->get('CompCode');
    $emp->DeptCode = $request->get('DeptCode');
    $emp->DesgCode = $request->get('DesgCode');
    $emp->ShiftCode = $request->get('ShiftGroupCode');
    $emp->EmpCode = $request->get('ID');
    $emp->EmpName = $request->get('EmpName');
    $emp->EmpAddress = $request->get('EmpAddress');
    $emp->EmpPhNo = $request->get('EmpPhNo');
    $emp->EmpMNo = $request->get('EmpPhNo');
    $emp->EmpEmail = $request->get('EmpEmail');
    $emp->EmpDOB = $request->get('EmpDOB');
    $emp->EmpMarried = $request->get('EmpMarried');
    $emp->EmpJoinDate = $request->get('EmpJoinDate');
    $emp->EmpPunchID = $request->get('ID');
    $emp->ActiveStatus = 1;
    $emp->EmpWeekOff = 0;
    $emp->MobNoSMS = $request->get('EmpPhNo');
    $emp->ShiftGroupCode = $request->get('ShiftGroupCode');
    $emp->BranchCode = 1;
    $emp->RefContact = '0';
    $emp->EmpSecondWeekOff = 0;
    $emp->EmpSecondWeekOffRule = 0;
    $emp->EmpHalfDay = 0;
    $emp->EmpHalfDayRule = 0;
    $emp->EmpAllowOT = 0;
    $date = new Carbon('today');

    $addPlan = $request->get('addPlan');
    if ($addPlan == 1) {
      $date->add(new DateInterval('P30D'));
    } else if ($addPlan == 2) {
      $date->add(new DateInterval('P90D'));
    } else if ($addPlan == 3) {
      $date->add(new DateInterval('P180D'));
    } else if ($addPlan == 4) {
      $date->add(new DateInterval('P365D'));
    }
    $emp->EmpResignDate = $date->format('Y-m-d H:i:s');
    $image = $request->file('image');
    $filename = time() . '.' . $image->getClientOriginalExtension();
    Image::make($image)->resize(300, 300)->save(storage_path('app\public\uploads\\' . $filename));
    $emp->EmpImgFilePath = $filename;

    $emp->save();

    return redirect('/EmpMaster')->with('success', 'Member details saved successfully');
  }

  /**
     * Display the specified resource.
     *
     * @param  \App\EmpMaster  $empMaster
     * @return \Illuminate\Http\Response
     */
  public function show(Request $request, $ID)
  {
    $request->user()->authorizeRoles(['manager']);
    $emp = EmpMaster::find($ID);
    return view('EmpMaster.show', compact('emp'));
  }

  /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\EmpMaster  $empMaster
     * @return \Illuminate\Http\Response
     */
  public function edit(Request $request, Int $id)
  {
    $request->user()->authorizeRoles(['manager']);
    $emp = EmpMaster::find($id);
    //error_log($emp->EmpName);


    return view('EmpMaster.edit', ["emp" => $emp]);
  }

  /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\EmpMaster  $empMaster
     * @return \Illuminate\Http\Response
     */
  public function update(Request $request, $id)
  {
    $request->user()->authorizeRoles(['manager']);
    $request->validate([
      'EmpName' => 'required',
      'EmpPhNo' => 'required',
      'EmpDOB' => 'required',
      'EmpEmail' => 'required',
      'EmpAddress' => 'required',
    ]);
    $addPlan = $request->get('addPlan');

    $emp = EmpMaster::find($id);

    $date = new DateTime($emp->EmpResignDate);
    $today = new Carbon('today');
    if ($date < $today) {
      $date = $today;
    }
    if ($addPlan == 1) {
      $date->add(new DateInterval('P30D'));
    } else if ($addPlan == 2) {
      $date->add(new DateInterval('P90D'));
    } else if ($addPlan == 3) {
      $date->add(new DateInterval('P180D'));
    } else if ($addPlan == 4) {
      $date->add(new DateInterval('P365D'));
    }
    $emp->EmpResignDate = $date->format('Y-m-d H:i:s');
    $emp->EmpName = $request->get('EmpName');
    $emp->EmpPhNo = $request->get('EmpPhNo');
    $emp->EmpDOB = $request->get('EmpDOB');
    $emp->EmpEmail = $request->get('EmpEmail');
    $emp->EmpAddress = $request->get('EmpAddress');
    if ($request->hasFile('image')) {
      $image = $request->file('image');
      $filename = time() . '.' . $image->getClientOriginalExtension();
      Image::make($image)->resize(300, 300)->save(storage_path('app\public\uploads\\' . $filename));
      $emp->EmpImgFilePath = $filename;
    }
    $emp->save();

    return redirect('/EmpMaster')->with('success', 'Member details updated successfully');
  }

  /**
     * Remove the specified resource from storage.
     *
     * @param  \App\EmpMaster  $empMaster
     * @return \Illuminate\Http\Response
     */
  public function destroy(Request $request, $id)
  {
    $request->user()->authorizeRoles(['manager']);
    $emp = EmpMaster::find($id);
    $emp->delete();
    return redirect('/EmpMaster')->with('success', 'Member has been deleted Successfully');
  }

  public function getPlanExpiry(Request $request)
  {
    $request->user()->authorizeRoles(['manager']);
    $date = new Carbon('last day of this month');

    $emp = EmpMaster::where('EmpResignDate', '<=', $date)->get();
    return view('EmpMaster.monPlan', ["emp" => $emp]);
  }
  public function getInoutDuration(Request $request)
  {
    $request->user()->authorizeRoles(['manager']);
    $reqDate = '';
    $inOutData = [];
    return view('EmpMaster.inout')->with(compact('inOutData', 'reqDate'));
  }
  public function getInoutDurationByDate(Request $request)
  {
    $request->user()->authorizeRoles(['manager']);
    $request->validate(['inoutDate' => 'required']);

    $reqDate =  $request->get('inoutDate');

    $inOutData =  DB::table('EmpMaster')
      ->join('AllDataSub', 'EmpMaster.EmpCode', '=', 'AllDataSub.EmpCode')
      ->selectRaw('datediff(MI, min(In_Out_Time),max(In_Out_Time))/60 as hours,(datediff(MI, min(In_Out_Time),max(In_Out_Time))%60) as minutes,Attn_Dt,EmpMaster.EmpName')
      ->where('Attn_Dt', '=', $reqDate)
      ->groupBy('EmpMaster.EmpName', 'AllDataSub.Attn_Dt')
      ->orderBy('AllDataSub.Attn_Dt')
      ->get();

    return view('EmpMaster.inout')
      ->with(compact('inOutData', 'reqDate'));
  }

  public function searchMembers(Request $request)
  {

    $request->user()->authorizeRoles(['employee', 'manager']);
    $CompMaster = DB::table('CompMaster')->get();
    $DeptMaster = DB::table('DeptMaster')->get();
    $DesgMaster = DB::table('DesgMaster')->get();
    $ShiftGroupMaster = DB::table('ShiftGroupMaster')->get();
    $ShiftMaster = DB::table('ShiftMaster')->get();

    return view('EmpMaster.search')->with(compact('CompMaster', 'DeptMaster', 'DesgMaster', 'ShiftGroupMaster', 'ShiftMaster'));
  }

  public function searchByFilter(Request $request)
  {

    $request->user()->authorizeRoles(['employee', 'manager']);

    $filters = [
      'EmpID' => $request->get('ID'),
      'DesgCode' => $request->get('DesgCode'),
      'EmpCode' => $request->get('ID'),
      'EmpName' => $request->get('EmpName'),
      'EmpAddress' => $request->get('EmpAddress'),
      'EmpPhNo' => $request->get('EmpPhNo'),
      'EmpMNo' => $request->get('EmpPhNo'),
      'EmpEmail' => $request->get('EmpEmail'),
      'EmpJoinDate' => $request->get('EmpJoinDate'),
      'EmpPunchID' => $request->get('ID'),
      'dtDiff' => $request->get('dtDiff')
    ];

    $employees = EmpMaster::where(function ($employees) use ($request, $filters) {
      foreach ($filters as $column => $value) {
        if (!$value == '') {
          if ($column == 'EmpID' || $column == 'EmpPunchID' || $column == 'EmpCode' || $column == 'DesgCode') {
            error_log("where($column, =, $value");
            $employees->where($column, '=', $value);
          }
          if ($column == 'EmpJoinDate') {

            $start = new DateTime(date("d-m-Y", strtotime($value)));
            $end = new DateTime(date("d-m-Y", strtotime($value . "+1 day")));
            //error_log("$column*$start*$end");
            $employees->whereBetween($column, [$start, $end]);
          }

          if (($column <> 'EmpJoinDate') && ($column <> 'dtDiff')) {
            error_log('2' . $column . $value);
            $employees->where($column, 'LIKE', '%' . $value . '%');
          }
          if ($column == 'dtDiff') {
            error_log('1' . $column . $value);
            $bin = $value;
            $employees->whereRaw("ABS(DATEDIFF(day,EmpResignDate,GETDATE())) <= $bin");
          }
        }
      }
    })->get();

    return view('EmpMaster.searchRes', compact('employees'));
  }
}
