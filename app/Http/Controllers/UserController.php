<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\User;
use App\UserLevel;
use DataTables;

class UserController extends Controller
{
    public function get_active_month(){
        $active_month_details = DB::connection('mysql')->select("SELECT `active_month` FROM `month_config` WHERE `status` = '0'");
        return response()->json(['month' => $active_month_details]);
    }

    public function change_active_month(){
        DB::beginTransaction();
        DB::connection('mysql')->statement("UPDATE `month_config`
                                            SET `status` = CASE WHEN `status` THEN 0 ELSE 1 END,
                                                `status` = CASE WHEN `status` THEN 1 ELSE 0 END");
        DB::commit();
        return response()->json(['messsage' => 'success']);
    }

    public function view_users()
    {
        $users = User::with('department')
            ->with('user_levels_id')
            ->orderBy('user_level_id', 'asc')
            ->get();

        return DataTables::of($users)
            ->addColumn('status', function ($user) {
                $result = "";
                if ($user->status == 0) {
                    $result .= '<center><span class="badge badge-pill badge-success">Active</span></center>';
                } else {
                    $result .= '<center><span class="badge badge-pill badge-secondary">Inactive</span></center>';
                }
                return $result;
            })
            ->addColumn('action', function ($user) {
                $result = "";
                $result .= '<button class="btn btn-primary text-center actionEditUser" user-id="' . $user->id . '" data-toggle="modal" data-target="#modalEditUser" data-keyboard="false"><i class="fas fa-edit"></i> Edit</button>&nbsp;';

                if ($user->status == 0) {
                    $result .= '<button class="btn btn-danger text-center actionDeactivateUser" user-id="' . $user->id . '" data-toggle="modal" data-target="#modalDeactivateUser" data-keyboard="false">Deactivate</button>';
                } else {
                    $result .= '<button class="btn btn-success text-center actionActivateUser" user-id="' . $user->id . '" data-toggle="modal" data-target="#modalActivateUser" data-keyboard="false">Activate</button>';
                }
                return $result;
            })
            ->rawColumns(['status', 'action'])
            ->make(true);
    }

    public function add_user(Request $request){
        date_default_timezone_set('Asia/Manila');
        session_start();

        $data = $request->all();
        $password = "pmi12345";

        $validator = Validator::make($data, [
            'name' => 'required',
            'email' => 'required|email',
            'username' => 'required|string',
            'department' => 'required',
            'userLevel' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['validation' => 'hasError', 'error' => $validator->messages()]);
        } else {
            if (User::where('name', $request->name)->where('user_level_id', $request->userLevel)->exists()) {
                return response()->json(['result' => 0]);
            } else {
                User::insert([
                    'name' => $request->name,
                    'email' => $request->email,
                    'username' => $request->username,
                    'password' => Hash::make($password),
                    'department_id' => $request->department,
                    'user_level_id' => $request->userLevel,
                    // 'user_access' => 0,
                    'status' => 0,
                ]);

                DB::commit();
                return response()->json(['result' => 1]);
            }
        }
    }

    public function deactivate_user(Request $request)
    {
        date_default_timezone_set('Asia/Manila');
        session_start();

        $data = $request->all();

        User::where('id', $request->user_id)
            ->update([
                'status' => 1
            ]);

        return response()->json(['result' => "1"]);
    }

    public function activate_user(Request $request)
    {
        date_default_timezone_set('Asia/Manila');
        session_start();

        $data = $request->all();

        User::where('id', $request->user_id)
            ->update([
                'status' => 0
            ]);

        return response()->json(['result' => "1"]);
    }

    public function get_id_edit_user(Request $request)
    {
        $user_data = User::where('id', $request->user_id)
            ->get();

        return response()->json(['user_name' => $user_data]);
    }

    public function edit_user(Request $request)
    {
        date_default_timezone_set('Asia/Manila');
        session_start();

        $data = $request->all();

        $validator = Validator::make($data, [
            'name' => 'required',
            'username' => 'required|alpha_spaces',
            'email' => 'required|email',
            'userLevel' => 'required',
            'department' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['validation' => 'hasError', 'error' => $validator->messages()]);
        } else {
            if (User::where('id', $request->name)->exists()) {
                return response()->json(['result' => 0]);
            } else {
                User::where('id', $request->user_id)
                    ->update([
                        'name' => $request->name,
                        'username' => $request->username,
                        'email' => $request->email,
                        'department_id' => $request->department,
                        'user_level_id' => $request->userLevel
                    ]);

                return response()->json(['result' => 1]);
            }
        }
    }

    public function sign_in(Request $request)
    {
        $user_data = array(
            'username' => $request->get('username'),
            'password' => $request->get('password'),
        );

        $validator = Validator::make($user_data, [
            'username' => 'required',
            'password' => 'required|alpha_num'
        ]);

        if ($validator->passes()) {
            if (Auth::attempt($user_data)) {
                session_start();
                $_SESSION["user_department"] = Auth::user()->department_id;
                $_SESSION['user_level'] = Auth::user()->user_level_id;
                $_SESSION['status'] = Auth::user()->status;

                Session::put('dept_id', $_SESSION['user_department']);
                // Session::get('dept_id');
                if ($_SESSION['user_level'] == 1 && $_SESSION['status'] == 0) {
                    return response()->json(['result' => "1", 'session' => $_SESSION["user_department"]]);
                } else if ($_SESSION['user_level'] == 2 && $_SESSION['status'] == 0) {
                    return response()->json(['result' => "2", 'session' => $_SESSION["user_department"]]);
                } else if ($_SESSION['user_level'] == 3 && $_SESSION['status'] == 0) {
                    return response()->json(['result' => "3", 'session' => $_SESSION["user_department"]]);
                } elseif ($_SESSION['status'] == 1) {
                    return response()->json(['result' => "4"]);
                }
            } else {
                return response()->json(['result' => "0", 'error_message' => 'We do not recognize your username and/or password. Please try again.', 'error' => $validator->messages()]);
            }
        } else {
            return response()->json(['validation' => "hasError", 'error' => $validator->messages()]);
        }
    }

    public function sign_out()
    {
        session_start();
        session_unset();
        session_destroy();
        Auth::logout();
        return response()->json(['result' => "1"]);
    }

    public function get_user_levels()
    {
        $user_levels = UserLevel::all();
        return response()->json(['user_level' => $user_levels]);
    }
}
