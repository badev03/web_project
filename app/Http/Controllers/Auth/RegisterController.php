<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
            'phone' => [ 'string', 'min:10', 'max:10'],
            'password-confirm'=> ['required', 'string', 'min:8', 'same:password'],
        ],[
            'name.required' => 'Vui lòng nhập tên',
            'name.string' => 'Tên phải là chuỗi',
            'name.max' => 'Tên không quá 255 ký tự',
            'email.required' => 'Vui lòng nhập email',
            'email.string' => 'Email phải là chuỗi',
            'email.email' => 'Email không đúng định dạng',
            'email.max' => 'Email không quá 255 ký tự',
            'email.unique' => 'Email đã tồn tại',
            'password.required' => 'Vui lòng nhập mật khẩu',
            'password.string' => 'Mật khẩu phải là chuỗi',
            'password.min' => 'Mật khẩu phải có ít nhất 8 ký tự',
            'phone.string' => 'Số điện thoại không đúng',
            'phone.min' => 'Số điện thoại phải có ít nhất 10 ký tự',
            'phone.max' => 'Số điện thoại không quá 10 ký tự',
            'password-confirm.required' => 'Vui lòng nhập lại mật khẩu',
            'password-confirm.string' => 'Mật khẩu phải là chuỗi',
            'password-confirm.min' => 'Mật khẩu phải có ít nhất 8 ký tự',
            'password-confirm.same' => 'Mật khẩu không khớp',
     
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone'=> $data['phone'],
            'password' => Hash::make($data['password']),
        ]);
    }
}
