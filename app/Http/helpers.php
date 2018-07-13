<?php

function checkIfPaid() {
    $start_date = session()->get('user')->subscription_startdate;
    $end_date   = session()->get('user')->subscription_enddate;
    if($start_date && $end_date) {
        $p_start_date = \Carbon\Carbon::parse($start_date);
        $p_end_date   = \Carbon\Carbon::parse($end_date);
        $date_now     = \Carbon\Carbon::now()->format('Y-m-d');
        if($p_start_date <= $p_end_date) {
            if($p_end_date >= $date_now) {
                return true;
            }
        }
    }
    return false;
}

function nonPaymentRoles() {
    $role = (session()->get('user')->role=='admin')?session()->get('user')->role:session()->get('user')->user_role_function;
    if( $role == 'admin') {
        if(isset(session()->get('user')->user_role_function) && strlen(session()->get('user')->user_role_function) > 1) {
            $role = session()->get('user')->user_role_function;
        }
    }
    if(in_array($role, config('permissions.no_payment')) ) {
        return true;
    }
    return false;
}
function caseSubmittersRoles() {
    $role = (session()->get('user')->role=='admin')?session()->get('user')->role:session()->get('user')->user_role_function;
    if( $role == 'admin') {
        if(isset(session()->get('user')->user_role_function) && strlen(session()->get('user')->user_role_function) > 1) {
            $role = session()->get('user')->user_role_function;
        }
    }
    if(in_array($role, config('permissions.submit_case')) ) {
        return true;
    }
    return false;
}
function caseHighlightsRoles() {
    $role = (session()->get('user')->role=='admin')?session()->get('user')->role:session()->get('user')->user_role_function;
    if( $role == 'admin') {
        if(isset(session()->get('user')->user_role_function) && strlen(session()->get('user')->user_role_function) > 1) {
            $role = session()->get('user')->user_role_function;
        }
    }
    if(in_array($role, config('permissions.highlight')) ) {
        return true;
    }
    return false;
}
function caseCategoriesRoles() {
    $role = (session()->get('user')->role=='admin')?session()->get('user')->role:session()->get('user')->user_role_function;
    if( $role == 'admin') {
        if(isset(session()->get('user')->user_role_function) && strlen(session()->get('user')->user_role_function) > 1) {
            $role = session()->get('user')->user_role_function;
        }
    }
    if(in_array($role, config('permissions.manage_category')) ) {
        return true;
    }
    return false;
}
function caseApproversRoles() {
    $role = (session()->get('user')->role=='admin')?session()->get('user')->role:session()->get('user')->user_role_function;
    if( $role == 'admin') {
        if(isset(session()->get('user')->user_role_function) && strlen(session()->get('user')->user_role_function) > 1) {
            $role = session()->get('user')->user_role_function;
        }
    }
    if(in_array($role, config('permissions.approve_case')) ) {
        return true;
    }
    return false;
}
function userManagerRoles() {
    $role = (session()->get('user')->role=='admin')?session()->get('user')->role:session()->get('user')->user_role_function;
    if( $role == 'admin') {
        if(isset(session()->get('user')->user_role_function) && strlen(session()->get('user')->user_role_function) > 1) {
            $role = session()->get('user')->user_role_function;
        }
    }
    if(in_array($role, config('permissions.manage_user')) ) {
        return true;
    }
    return false;
}
?>