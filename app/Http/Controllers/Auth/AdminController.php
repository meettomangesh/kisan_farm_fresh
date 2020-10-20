<?php
namespace App\Http\Controllers\Auth;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\LoginController as DefaultLoginController;

class AdminController extends DefaultLoginController
{
    protected $redirectTo = '/admin/home';
    public function __construct()
    {
        $this->middleware('guest:admin')->except('logout');
    }
    public function showLoginForm()
    {
        return view('auth.admin');
    }
    public function username()
    {
        return 'mobile_number';
    }
    protected function guard()
    {
        return Auth::guard('admin');
    }
}