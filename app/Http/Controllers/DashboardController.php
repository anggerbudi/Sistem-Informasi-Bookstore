<?php

namespace App\Http\Controllers;

class DashboardController extends Controller
{
    private static string $title, $state;

    public function __construct()
    {
        self::$state = 'dashboard';
        self::$title = 'Dashboard';
    }

    public function index()
    {
        return view('dashboard.index', [
            'title' => self::$title,
            'state' => self::$state,
        ]);
    }
}
