<?php

namespace App\Http\Controllers;

use Inertia\Inertia;

class TodoController extends Controller
{
    public function index()
    {
        return Inertia::render('Todos/Index', [
            'title' => 'ttt'
        ]);
    }
}
