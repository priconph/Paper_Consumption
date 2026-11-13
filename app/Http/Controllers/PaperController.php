<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Paper;
use DataTables;

class PaperController extends Controller
{
    public function view_papers()
    {
        $papers = Paper::all();

        return DataTables::of($papers)
            ->addColumn('status', function ($paper) {
                $result = "";
                if ($paper->status == 0) {
                    $result .= '<center><span class="badge badge-pill badge-success">In use</span></center>';
                } else {
                    $result .= '<center><span class="badge badge-pill badge-secondary">Not In use</span></center>';
                }
                return $result;
            })
            ->addColumn('action', function ($paper) {
                $result = "";
                $result .= '<button class="btn btn-primary text-center actionEditPaper" paper-id="' . $paper->id . '" data-toggle="modal" data-target="#modalEditItem" data-keyboard="false"><i class="fas fa-edit"></i> Edit</button>&nbsp;';

                // if ($paper->status == 0) {
                //     $result .= '<button class="btn btn-danger text-center actionDeactivatePaper" paper-id="' . $paper->id . '" data-toggle="modal" data-target="#modalDeactivatePaper" data-keyboard="false">Deactivate</button>';
                // } else {
                //     $result .= '<button class="btn btn-success text-center actionActivatePaper" paper-id="' . $paper->id . '" data-toggle="modal" data-target="#modalActivatePaper" data-keyboard="false">Activate</button>';
                // }
                return $result;
            })
            ->rawColumns(['status', 'action'])
            ->make(true);
    }

    public function add_papers(Request $request)
    {
        date_default_timezone_set('Asia/Manila');
        session_start();

        $data = $request->all();

        $validator = Validator::make($data, [
            'paper_name' => 'required|alpha_spaces'
        ]);

        if ($validator->fails()) {
            return response()->json(['validation' => 'hasError', 'error' => $validator->messages()]);
        } else {
            if (Paper::where('name', $request->paper_name)->exists()) {
                return response()->json(['result' => 0]);
            } else {
                Paper::insert([
                    'name' => $request->paper_name,
                    'status' => 0,
                ]);

                DB::commit();
                return response()->json(['result' => 1]);
            }
        }
    }

    public function deactivate_papers(Request $request)
    {
        date_default_timezone_set('Asia/Manila');
        session_start();

        $data = $request->all();

        Paper::where('id', $request->paper_id)
            ->update([
                'status' => 1
            ]);

        return response()->json(['result' => "1"]);
    }

    public function activate_papers(Request $request)
    {
        date_default_timezone_set('Asia/Manila');
        session_start();

        $data = $request->all();

        Paper::where('id', $request->paper_id)
            ->update([
                'status' => 0
            ]);

        return response()->json(['result' => "1"]);
    }

    public function get_id_edit(Request $request)
    {
        $paper = Paper::where('id', $request->paper_id)->get();

        return response()->json(['paper_name' => $paper]);
    }

    public function edit_paper(Request $request)
    {
        date_default_timezone_set('Asia/Manila');
        session_start();

        $data = $request->all();

        $validator = Validator::make($data, [
            'paper_name' => 'required|alpha_spaces'
        ]);

        if ($validator->fails()) {
            return response()->json(['validation' => 'hasError', 'error' => $validator->messages()]);
        } else {
            if (Paper::where('name', $request->paper_name)->exists()) {
                return response()->json(['result' => 0]);
            } else {
                Paper::where('id', $request->paper_id)
                    ->update([
                        'name' => $request->paper_name,
                    ]);

                return response()->json(['result' => 1]);
            }
        }
    }

    public function get_papers(Request $request)
    {
        $papers = Paper::where('status', 0)->get();
        return response()->json(['paper' => $papers]);
    }

    public function get_papers_for_filter()
    {
        $papers = Paper::where('status', 0)->get();

        // $result .= '<option value="">All</option>';
        return response()->json(['paper' => $papers]);
    }
}
