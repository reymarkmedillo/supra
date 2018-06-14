<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\CaseModel;

class CategoryController extends Controller
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
     * Create category view
     *
     * @return view
     */
    public function createCategory() 
    {
        $categories = $this->case->getAllCategories();
        
        return view('category.add', ['categories'=> $categories->categories]);
    }
    /**
     * Edit category view
     *
     * @return view
     */
    public function editCategory() 
    {
        $categories = $this->case->getAllCategories();
        
        return view('category.edit', ['categories'=> $categories->categories]);
    }
    /**
     * To determine if edit/delete then redirect
     *
     * @param Request $request get form data
     * 
     * @return redirect
     */
    public function postEditCategory(Request $request) 
    {
        if ($request->has('btnUpdateCase')) {
            return redirect()->route('updateCategory', ['category_id'=> $request->input('cat_search')]);
        } elseif ($request->has('btnDeleteCase')) {
            $this->case->deleteCategory($request->input('cat_search'));
            return redirect()->back()->with("message", "Deleted Category Successfully.");
        }
    }
    /**
     * To get category info and display in view
     *
     * @param category_id $category_id search
     * 
     * @return view
     */
    public function updateCategory($category_id) 
    {
        $categories = $this->case->getAllCategories();
        $category = $this->case->getCategoryInfo($category_id);
        if(!isset($category->category->id)) {
            abort(404);
        }
        return view('category.update', ['categories'=> $categories->categories,'selectedCategory' => $category->category]);
    }
    /**
     * Update category data
     *
     * @param Request $request get form data
     * 
     * @return view
     */
    public function postupdateCategory(Request $request, $category_id) 
    {
        $categories = $this->case->getAllCategories(); // get list
        $selectedCategory = $this->case->getCategoryInfo($category_id);

        $category = $this->case->updateCategory($category_id, $request->all());
        return redirect()->back()->with("message", "Updated Category Successfully.");
    }
    /**
     * Save new category data
     *
     * @param Request $request get form data
     * 
     * @return view
     */
    public function postCreateCategory(Request $request) 
    {
        $categories = $this->case->getAllCategories(); // get list
        $category = $this->case->createCategory($request->all()); // create new
        return redirect()->back()->with("message", "Created New Category Successfully.");
    }
}
