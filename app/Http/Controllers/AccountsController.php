<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AccountsController extends Controller
{

  public function addUser() {

    return view('accounts.add');

  }

  public function enterSuperuser() {

    return view('accounts.superuser');

  }

  public function createSuperuser(Request $request) {

    $user = new \App\User;

    if ($request->verification_code == '09770873166') {

      $user->name = $request->name;
      $user->username = $request->username;
      $user->role = 'administrator';
      $user->password = bcrypt($request->password);

      $user->save();

      return view('authentication.login');

    } else {

      session()->flash('error', 'You shall not pass.');
      return redirect()->back();

    }

  }

  public function create() {

    $user = new \App\User;
    $existing = $user->where('username', '=', request('username'))->get();

    if (count($existing) != 0) {
      session()->flash('error_existing', 'Account Already Exist');
      return redirect()->back();
    }

    // Checks if passwords match
    if (request('password') == request('password_confirmation')) {
      $user->name = request('name');
      $user->username = request('username');
      $user->password = bcrypt(request('password'));
      $user->role = request('role');

      $user->save();

      auth()->attempt([
        'username' => $user->username,
        'password' => $user->password
      ]);

      $account = [$user];

      session()->flash('success_create_user', 'User Profile has been created: '.$user->username);
      return view('accounts.view', compact('account'));
    } else {

      session()->flash('error_password', 'Passwords did not match');
      return redirect()->back();

    }

  }

  public function getUserLogs(Request $request) {

    $fileset = new \App\FileSet;
    $logs = $fileset->where('uploader', '=', $request->username)->get();

    return compact('logs');

  }

}
