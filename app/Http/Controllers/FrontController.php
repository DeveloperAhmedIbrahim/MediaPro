<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Mail;

class FrontController extends Controller
{
    public function index()
    {
        return view('media.index');
    }
    public function contactus()
    {
        return view('media.contact');
    }
    public function feature()
    {
        return view('media.feature');
    }
    public function pricing()
    {
        return view('media.pricing');
    }
    public function blog()
    {
        return view('media.blog');
    }
    public function affiliates()
    {
        return view('media.affiliates');
    }
    public function privacy_policy()
    {
        return view('media.privacy-policy');
    }
    public function termscondition()
    {
        return view('media.terms&condition');
    }
    public function test_email()
    {

    }
}
