<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class PageController extends Controller
{

  public function login() {

    return view('authentication.login');

  }

  public function logout() {

    Auth::logout();
    return view('authentication.login');

  }

  public function dashboard() {

    return view('authentication.home');

  }

  public function accountsList() {

    $user = new \App\User;
    $accounts = $user->all();
    return view('accounts.accounts', compact('accounts'));

  }

  public function viewProfile($username) {

    $user = new \App\User;
    $account = $user->where('username', '=', $username)->get();

    return view('accounts.view', compact('account'));

  }

  public function attempt() {

    if (auth()->attempt(['username' => request('username'), 'password' => request('password')])) {
      return redirect('/dashboard');
    } else {
      return redirect()->back()->witherrors(['msg' => 'Login Failed']);
    }


  }

}
