<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\CaseModel;

class CaseApprovedController extends Controller {

    public function __construct(CaseModel $case) {
        $this->case = $case;
    }

    public function listCase(Request $request) {
        $request->request->add(['db'=> 'live']);
        $cases = $this->case->getAllDraftCases($request->all());
        return view('approved_case.list', ['cases' => $cases->cases]);
    }

    public function viewCase($case_id, Request $request) {
        $request->request->add(['db'=> 'live']);
        $filtered_case_list = array();
        $case = $this->case->viewApprovedCase($case_id);
        $case_list = $this->case->getAllDropdownDraftCases($request->all()); // this is not really from draft cases it's already from live because of $request->input('live')
        foreach($case_list->cases as $arr) {
            if($arr->id != $case_id) {
                array_push($filtered_case_list, $arr);
            }
        }
        // dd($filtered_case_list);
        $top_categories = $this->case->getCategory(0);
        if(!$case->case) {
            abort(404);
        }

        $case_category = array();

        if($case->case->xgr) {
            foreach($case->case->xgr as $value) {
                array_push($case_category, $value->topic);
            }
        }

        $case_parent = 0;
        $case_child = 0;

        if(isset($case->case->parent->id)) {
            $case_parent = $case->case->parent->id;
        }
        if(isset($case->case->child->id)) {
            $case_child = $case->case->child->id;
        }

        $fulltxt = explode('/', $case->case->full_txt);
        $fulltxt_filename = isset($fulltxt[5])?$fulltxt[5]:null;

        return view('approved_case.view', [
            'case' => $case->case,
            'case_list' => $filtered_case_list,
            'case_category' => $case_category,
            'case_child' => $case_child,
            'case_parent' => $case_parent,
            'top_categories' => $top_categories->categories,
            'fulltxt_filename' => $fulltxt_filename
        ]);
    }

    public function postUpdateApprovedCase(Request $request, $case_id) {
        $top_categories = $this->case->getCategory(0);
        if($request->hasFile('full_txt')) {
            $validator = \Validator::make($request->all(), [
                'full_txt' => 'mimes:pdf,txt|max:9000'
            ]);
            if($validator->fails()) {
                $case = $this->case->viewApprovedCase($case_id);
                $case_list = $this->case->getAllDropdownDraftCases();
                $case_category = json_encode($case->case->topic);
                $case_parent = 0;
                $case_child = 0;
                if(strpos($case_category, ',') !== false) {
                    $new_case_category = explode(",",$case_category);
                    $case_category = $new_case_category;
                }
                if(isset($case->case->parent->id)) {
                    $case_parent = $case->case->parent->id;
                }
                if(isset($case->case->child->id)) {
                    $case_child = $case->case->child->id;
                }
                return view('approved_case.view', [
                    'case' => $case->case,
                    'case_list' => $case_list->cases,
                    'case_category' => $case_category,
                    'case_child' => $case_child,
                    'case_parent' => $case_parent,
                    'top_categories' => $top_categories->categories
                ])->withErrors($validator->errors());
            }
            $file = $request->file('full_txt');
            $path = public_path().config('define.fulltxt_path');
            $extension = $request->file('full_txt')->getClientOriginalExtension();
            $name = str_replace('.', '', $request->input('gr')).'.'.$extension;
            $request->request->add(['fulltxt' => env('APP_URL').config('define.fulltxt_path').$name]);
            // "DELETE PREVIOUS FILE"
            $case = $this->case->viewApprovedCase($case_id);
            \File::delete($case->case->full_txt);
            // "UPLOAD THE NEW ONE"
            $file->move($path, $name);
        }

        // "START > REFERENCE DROPDOWN LISTS"
        if($request->has('case_parent') && $request->has('case_child')) {
            $validator = \Validator::make($request->all(), [
                'case_parent' => 'required',
                'case_child' => 'required|different:case_parent',
                'case_related_to' => 'different:case_parent,case_child'
            ]);
            if($validator->fails()) {
                $case = $this->case->viewApprovedCase($case_id);
                $case_list = $this->case->getAllDropdownDraftCases();
                return view('approved_case.view', [
                    'message' => '',
                    'case' => $case->case,
                    'case_list' => $case_list->cases,
                    'case_category' => $case_category,
                    'top_categories' => $top_categories->categories
                ])->withErrors($validator->errors());
            }
        }
        // "END < REFERENCE DROPDOWN LISTS"

        $request->request->add(['db'=> 'live']);
        $date = date('Y-m-d', strtotime($request->input('date')));
        if($request->has('date')) {
            $request->merge(array('date' => $date));
        }

        $case = $this->case->updateApprovedCase($case_id, $request->all());
        session()->flash('msg-success',$case->message);
        return redirect()->route('listApprovedCase');
    }

    public function deleteCase($case_id) {
        $case = $this->case->deleteCase($case_id);
        return response()->json($case);
    }
}
