<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class AdminController extends Controller
{
    public function index()
    {
        return view('dash.layout.main'); 
    }

    private function renderView($view, $data = []) {
    if (request()->ajax()) {
        return view('dash.sections.' . $view, $data);
    }
    return view('dash.layout.main', $data);
    }

    public function dashboard() {
    return $this->renderView('dash');
    }

    public function statics() {
    return $this->renderView('stats');
    }

    public function users() {
    return $this->renderView('users', ['users' => User::all()]);
    }

    public function orders() {
    return $this->renderView('orders');
    }

    public function offers() {
    return $this->renderView('offers');
    }
    
    public function auctions() {
    return $this->renderView('auctions');
    }

    public function reviews() {
    return $this->renderView('reviews');
    }

    public function settings() {
    return $this->renderView('settings');
    }

}
