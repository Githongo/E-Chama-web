<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CommunicationsController extends Controller
{
    public function newSms(){
        return view('admin.sms');
    }

    public function newNotice(){
        return view('admin.notice');
    }
}
