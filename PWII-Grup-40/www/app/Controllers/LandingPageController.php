<?php

namespace App\Controllers;

class LandingPageController extends BaseController
{
    public function index(): string
    {


        return view('landing_page');
    }
}
