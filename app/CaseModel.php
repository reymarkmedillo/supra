<?php

namespace App;

use App\ApiModel;

class CaseModel extends ApiModel
{
    public function searchCase($data) {
        $res = $this->callByAuth('POST', env('API_URL').'/search-case', $data);
        return $res->getBody();
    }

    public function getCategory($parent) {
        $res = $this->callByAuth('GET', env('API_URL').'/categories/'.$parent);
        return $res->getBody();
    }
    public function getAllCategories($data = array()) {
        $res = $this->callByAuth('GET', env('API_URL').'/categories-all', $data);
        return $res->getBody();
    }
    public function getCategoriesTree($data = array()) {
        $res = $this->callByAuth('GET', env('API_URL').'/categories-tree', $data);
        return $res->getBody();
    }
    public function getCategoryInfo($category_id) {
        $res = $this->callByAuth('GET', env('API_URL').'/categories-view/'.$category_id);
        return $res->getBody();
    }
    public function updateCategory($category_id, $data) {
        $res = $this->callByAuth('GET', env('API_URL').'/categories-update/'.$category_id, $data);
        return $res->getBody();
    }
    public function deleteCategory($category_id) {
        $res = $this->callByAuth('GET', env('API_URL').'/categories-remove/'.$category_id);
        return $res->getBody();
    }
    public function createCategory($data) {
        $res = $this->callByAuth('POST', env('API_URL').'/categories-create', $data);
        return $res->getBody();
    }

    public function createCase($data) {
        $res = $this->callByAuth('POST', env('API_URL').'/drafts/create-case', $data);
        return $res->getBody();
    }

    public function getAllDraftCases($data = array()) {
        $res = $this->callByAuth('GET', env('API_URL').'/drafts/list-case', $data);
        return $res->getBody();
    }

    public function getAllDropdownDraftCases($data = array()) {
        $res = $this->callByAuth('GET', env('API_URL').'/drafts/list-dropdown-case', $data);
        return $res->getBody();
    }

    public function getCasesByCategory($data = array()) {
        $res = $this->callByAuth('POST', env('API_URL').'/list-dropdown/case-by-category', $data);
        return $res->getBody();
    }

    public function approveDraftCase($case_id, $data) {
        $res = $this->callByAuth('POST', env('API_URL').'/drafts/approval-case/'.$case_id, $data);
        return $res->getBody();
    }

    public function viewApprovedCase($case_id) {
        $res = $this->callByAuth('GET', env('API_URL').'/view-case/'.$case_id);
        return $res->getBody();
    }

    public function updateApprovedCase($case_id, $data) {
        $res = $this->callByAuth('POST', env('API_URL').'/drafts/update-case/'.$case_id, $data);
        return $res->getBody();
    }

    public function postCreateXgr($data) {
        $res = $this->callByAuth('POST', env('API_URL').'/case/approved/create-xgr', $data);
        return $res->getBody();
    }

    public function deleteCase($case_id) {
        $res = $this->callByAuth('GET', env('API_URL').'/remove/'.$case_id);
        return $res->getBody();
    }
}
