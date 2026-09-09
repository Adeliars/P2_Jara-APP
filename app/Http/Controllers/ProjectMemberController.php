<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProjectMemberController extends Controller
{
    public function create()
    {
        return view('members.add');
    }

    public function store(Request $request)
    {
        return "Member added successfully!";
    }
}
