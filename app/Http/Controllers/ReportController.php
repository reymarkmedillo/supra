<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\CaseModel;
/** 
 * Report Controller
 * 
 * @category Reports
 * @package  None
 * @author   Rei <rmmedillo@gmail.com>
 * @license  MIT http://opensource.org/licenses/MIT
 * @link     admin.tier-app.com/reports
 */
class ReportController extends Controller
{
    /**
     * Create a new authentication controller instance.
     *
     * @param CaseModel $case ..
     * 
     * @return void
     */
    public function __construct(CaseModel $case)
    {
        $this->case = $case;
    }
    /**
     * Category selection page
     *
     * @param $request $request ..
     * 
     * @return array
     */
    public function getCategoryTree(Request $request) 
    {
        if(nonPaymentRoles()) {
            if(!caseCategoriesRoles()) {
                abort(404);
            }
        } else {
            if (!checkIfPaid()) {
                abort(404);
            } else {
                if(!caseCategoriesRoles()) {
                    abort(404);
                }
            }
        }
        $request->request->add(['parent_id' => "0"]);
        $categories = $this->case->getAllCategories($request->all());
        return view('report.main-category-selection', ['categories'=> $categories->categories]);
    }
    /**
     * Category tree page
     *
     * @param $request $request ..
     * 
     * @return array
     */
    public function postCategoryTree(Request $request) 
    {
        if(nonPaymentRoles()) {
            if(!caseCategoriesRoles()) {
                abort(404);
            }
        } else {
            if (!checkIfPaid()) {
                abort(404);
            } else {
                if(!caseCategoriesRoles()) {
                    abort(404);
                }
            }
        }
        $case_list = $this->case->getAllDropdownDraftCases($request->all());

        $rw = false;
        $category_tree = $this->case->getCategoriesTree($request->all());
        if($request->has('action') && $request->input('action') == 'rw') {
            $rw = true;
        }
        return view(
            'report.view-category-tree', [
            'category_tree' => $category_tree->category, 
            'main_category_name' => $category_tree->main_category,
            'rw' => $rw,
            'cases' => $case_list->cases
            ]
        );
    }

    public function getCasesByCategory(Request $request) {
        $categories = $this->case->getCasesByCategory($request->all());
        return response()->json($categories);
    }
}
