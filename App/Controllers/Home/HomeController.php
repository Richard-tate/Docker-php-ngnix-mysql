<?php

namespace App\Controllers\Home;

use Framework\Controller;

class HomeController extends Controller
{
    /**
     *  constructor function
     *
     *  @return void
     */
    public function __construct(  )
    {
        parent::__construct();
    }


    /**
     *  Home page controller
     *
     *  @return void
     */

    public function index(): void
    {
        $this->view('Home', ['title' => 'Home']);
    }
}