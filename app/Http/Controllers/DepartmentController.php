<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Department;
use DataTables;

class DepartmentController extends Controller
{
    public function view_departments()
    {
        $departments = Department::all();

        return DataTables::of($departments)
            ->addColumn('status', function ($department) {
                $result = "";
                if ($department->status == 0) {
                    $result .= '<center><span class="badge badge-pill badge-success">Active</span></center>';
                } else {
                    $result .= '<center><span class="badge badge-pill badge-secondary">Inactive</span></center>';
                }
                return $result;
            })
            ->addColumn('action', function ($department) {
                $result = "";
                $result .= '<button class="btn btn-primary text-center actionEditDepartment" department-id="' . $department->id . '" data-toggle="modal" data-target="#modalEditDepartment" data-keyboard="false"><i class="fas fa-edit"></i> Edit</button>&nbsp;';

                if ($department->status == 0) {
                    $result .= '<button class="btn btn-danger text-center actionDeactivateDepartment " department-id="' . $department->id . '" data-toggle="modal" data-target="#modalDeactivateDepartment" data-keyboard="false">Deactivate</button>';
                } else {
                    $result .= '<button class="btn btn-success text-center actionActivateDepartment" department-id="' . $department->id . '" data-toggle="modal" data-target="#modalActivateDepartment" data-keyboard="false">Activate</button>';
                }
                return $result;
            })
            ->rawColumns(['status', 'action'])
            ->make(true);
    }

    public function add_department(Request $request)
    {
        date_default_timezone_set('Asia/Manila');
        session_start();

        $data = $request->all();

        $validator = Validator::make($data, [
            'department_name' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json(['validation' => 'hasError', 'error' => $validator->messages()]);
        } else {
            if (Department::where('name', $request->department_name)->exists()) {
                return response()->json(['result' => 0]);
            } else {
                Department::insert([
                    'name' => $request->department_name,
                    'status' => 0,
                ]);

                DB::commit();
                return response()->json(['result' => 1]);
            }
        }
    }

    public function deactivate_department(Request $request)
    {
        date_default_timezone_set('Asia/Manila');
        session_start();

        $data = $request->all();

        Department::where('id', $request->department_id)
            ->update([
                'status' => 1
            ]);

        return response()->json(['result' => "1"]);
    }

    public function activate_department(Request $request)
    {
        date_default_timezone_set('Asia/Manila');
        session_start();

        $data = $request->all();

        Department::where('id', $request->department_id)
            ->update([
                'status' => 0
            ]);

        return response()->json(['result' => "1"]);
    }

    public function get_id_edit_department(Request $request)
    {
        $department = Department::where('id', $request->department_id)->get();

        return response()->json(['department_name' => $department]);
    }

    public function edit_department(Request $request)
    {
        date_default_timezone_set('Asia/Manila');
        session_start();

        $data = $request->all();

        $validator = Validator::make($data, [
            'department_name' => 'required|alpha_spaces'
        ]);

        if ($validator->fails()) {
            return response()->json(['validation' => 'hasError', 'error' => $validator->messages()]);
        } else {
            if (Department::where('name', $request->department_name)->exists()) {
                return response()->json(['result' => 0]);
            } else {
                Department::where('id', $request->department_id)
                    ->update([
                        'name' => $request->department_name,
                    ]);

                return response()->json(['result' => 1]);
            }
        }
    }

    public function get_department(Request $request)
    {
        $departments = Department::all();
        return response()->json(['department' => $departments]);
    }
}
