<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\CaseModel;

class CaseController extends Controller
{
    public function __construct(CaseModel $case) {
        $this->case = $case;
    }

    public function createCase() {
        if(nonPaymentRoles()) {
            if(!caseSubmittersRoles()) {
                abort(404);
            }
        } else {
            if (!checkIfPaid()) {
                abort(404);
            } else {
                if(!caseSubmittersRoles()) {
                    abort(404);
                }
            }
        }

        $top_categories = $this->case->getCategory(0);
        $case_list = $this->case->getAllDropdownDraftCases();
        return view('case.add', [
            'message' => '',
            'case_list' => $case_list->cases,
            'top_categories' => $top_categories->categories
        ]);
    }

    public function getCategory(Request $request, $parent_id) {
        $categories = $this->case->getCategory($parent_id);
        return response()->json($categories->categories);
    }

    public function postCreateCase(Request $request) {
        $case_list = $this->case->getAllDropdownDraftCases();
        $top_categories = $this->case->getCategory(0);
        // "START > FULLTXT UPLOAD FILE"
        if($request->hasFile('full_txt')) {
            $validator = \Validator::make($request->all(), [
                'full_txt' => 'mimes:pdf,txt|max:9000'
            ]);
            if($validator->fails()) {
                $request->flash();
                return view('case.add', [
                    'message' => '',
                    'case_list' => $case_list->cases,
                    'top_categories' => $top_categories->categories
                ])->withErrors($validator->errors());
            }
            $file = $request->file('full_txt');
            $path = public_path().config('define.fulltxt_path');
            $extension = $request->file('full_txt')->getClientOriginalExtension();
            $name = str_replace('.', '', $request->input('gr')).'.'.$extension;
            $request->request->add(['fulltxt' => env('APP_URL').config('define.fulltxt_path').$name]);
            $file->move($path, $name);
        }
        // "END < FULLTXT UPLOAD FILE"

        // "START > REFERENCE DROPDOWN LISTS"
        if($request->has('case_parent') && $request->has('case_child')) {
            $validator = \Validator::make($request->all(), [
                'case_parent' => 'required',
                'case_child' => 'required|different:case_parent',
                'case_related_to' => 'different:case_parent,case_child'
            ]);
            if($validator->fails()) {
                $request->flash();
                return view('case.add', [
                    'message' => '',
                    'case_list' => $case_list->cases,
                    'top_categories' => $top_categories->categories
                ])->withErrors($validator->errors());
            }
        }
        // "END < REFERENCE DROPDOWN LISTS"
        $date = date('Y-m-d', strtotime($request->input('date')));
        if($request->has('date')) {
            $request->merge(array('date' => $date));
        }

        $case = $this->case->createCase($request->all());
        return view('case.add', [
            'topics' => '',
            'message' => isset($case->message)?$case->message:'',
            'case_list' => $case_list->cases,
            'top_categories' => $top_categories->categories
        ]);
    }

    public function listCase() {
        $cases = $this->case->getAllDraftCases();
        return view('case.list', ['cases' => $cases->cases]);
    }

    public function postApproveCase(Request $request, $case_id) {
        if(!caseApproversRoles()) {
            abort(404);
        }
        $case = $this->case->approveDraftCase($case_id, $request->all());
        return response()->json($case);
    }
}
