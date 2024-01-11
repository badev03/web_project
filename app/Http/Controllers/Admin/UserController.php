<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Traits\AdminTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    use AdminTrait;
    /**
     * Display a listing of the resource.
     */
    const BASE_URL  = 'back-end.page';

    public function index()
    {
        $users = User::all();
        return view(Self::BASE_URL . '.user.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view(Self::BASE_URL . '.user.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
         $this->validateUser($request);

        try {
            $user = new User();
            $user->password = bcrypt($request->password);
            $user->fill($request->except(['_token', 'avatar', 'confirm-password']));
            if ($request->hasFile('avatar') && $request->file('avatar')->isValid()) {
                $avatar = $request->file('avatar')->store('images/avatar');
                Storage::disk('s3')->setVisibility( $avatar, 'public');
                $url = Storage::disk('s3')->url( $avatar);
                $user->avatar = $url;
            } else {
                $user->avatar = null;
            }
            $user->save();
            return redirect()->route('users.index')->with('success', 'Thêm thành công');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Thêm thất bại');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }
    public function validateUser(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users,email',
            'password' => 'required|min:6|max:20',
            'confirm-password' => 'required|same:password',
            'phone' => 'numeric',

        ], [
            'name.required' => 'Tên không được để trống',
            'email.required' => 'Email không được để trống',
            'email.unique' => 'Email đã tồn tại',
            'password.required' => 'Mật khẩu không được để trống',
            'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự',
            'password.max' => 'Mật khẩu không được quá 20 ký tự',
            'confirm-password.required' => 'Xác nhận mật khẩu không được để trống',
            'confirm-password.same' => 'Xác nhận mật khẩu không đúng',
            'phone.numeric' => 'Số điện thoại phải là số',

        ]);
        return $request;
    }
    public function updateStatus($id)
    {
        $results = $this->status($id, User::class);
        if (isset($results['error'])) {
            return redirect()->back()->with('error', $results['error']);
        }
        return redirect()->back()->with('success', $results['success']);
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
