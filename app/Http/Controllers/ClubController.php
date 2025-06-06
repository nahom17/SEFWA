<?php
namespace App\Http\Controllers;

class ClubController extends Controller
{
    public function index()
    {
        return view('clubs.index');
    }
}
