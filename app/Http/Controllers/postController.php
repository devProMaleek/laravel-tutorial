<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class postController extends Controller
{
    public  function index($username)
    {
        return view('login', compact('username'));
    }

    public function form($fname, $lname)
    {
        return view('result', compact('fname', 'lname'));
    }

    public function list()
    {
        $people = array('Abdulmalik', 'Adebayo', 'Adeola', 'Aishat', 'Abdullah', 'Abdulrahman', 'Ummukulthum');
        return view('contact', compact('people'));
    }
}
