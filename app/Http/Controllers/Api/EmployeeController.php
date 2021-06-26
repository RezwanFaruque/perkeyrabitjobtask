<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\SelectedEmployee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $employees = Employee::all();


        return DataTables::of($employees)->addColumn('action', function ($row) {
            $idx = $row->id;
            $btn = "<a href='javascript:void(0)' id='delete' data-id='$idx' class='edit btn btn-danger btn-sm'>$idx</a>";
            return $btn;
        })->toJson();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([

            'name' => 'required',
            'designation' => 'required',

        ]);

        $employee = new Employee();

        $employee->name = $request->name;
        $employee->designation = $request->designation;


        $employee->save();

        if ($employee->save()) {
            $data = [
                'status' => 'success',
                'message' => 'Employee created successfully',
            ];
        } else {
            $data = [
                'status' => 'error',
                'message' => 'Failed Something Went Wrong',
            ];
        }

        return response()->json($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $employee = Employee::find($id);
        if ($employee) {
            $data = [
                'status' => 'success',
                'message' => 'Employee found',
                'data'   => $employee,
            ];
        } else {
            $data = [
                'status' => 'error',
                'message' => 'Employee Does not exist',
            ];
        }

        return response()->json($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([

            'name' => 'required',
            'designation' => 'required',

        ]);

        $employee = Employee::find($id);

        if ($employee) {
            $employee->name = $request->name;
            $employee->designation = $request->designation;


            $employee->update();

            $uemployee = Employee::find($employee->id);

            if ($employee->update()) {
                $data = [
                    'status' => 'success',
                    'message' => 'Employee Updated successfully',
                    'data'    => $uemployee,
                ];
            } else {
                $data = [
                    'status' => 'error',
                    'message' => 'Failed Something Went Wrong',
                ];
            }
    
        }

        return response()->json($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $employee = Employee::find($id);

        if ($employee) {
            $employee->delete();
            $data = [
                'status' => 'success',
                'message' => 'Employee Deleted Successfully',
            ];
        } else {
            $data = [
                'status' => 'error',
                'message' => 'Employee Does not exist',
            ];
        }

        return response()->json($data);
    }

    public function fetchAllDesignation(){
        $designations = DB::table('employees')->select('designation')->distinct('designation')->get();

        if($designations){
            $data = [
                'status' => 'success',
                'data' => $designations,
            ];
        }
        
        return response()->json($data);
        
    }

    public function employeeSearch(Request $request){

        $request->validate([
            'designation' => 'required'
        ]);

        $searchemployees = Employee::where('designation', 'LIKE', "%{$request->designation}%")->get();
        
       $data = [
           'status' => 'success',
           'data' => $searchemployees,
       ];

       return response()->json($data);
    }


    public function saveSelectedEmployee(Request $request){
        

        foreach($request->selectedemployees as $key => $selemployess){

            $selectedemps = new SelectedEmployee();

            $selectedemps->name = $selemployess['name'];
            $selectedemps->address = $selemployess['address'];
            $selectedemps->phone_number = $selemployess['phone_number'];
            $selectedemps->email = $selemployess['email'];

            $selectedemps->save();
               
            
        }

        $data = [
            'status' => 'success',
            'message' => 'Selected Employee save successfully',
        ];

        return response()->json($data);

    }
}
