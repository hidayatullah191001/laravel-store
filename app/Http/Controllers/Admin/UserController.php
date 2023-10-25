<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.admin.user.index', [
            'users'=> User::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.admin.user.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    {
        $data = $request->all();
        $data['password'] = bcrypt($request->password);
        User::create($data);
        return redirect()->route('user.index')->with('success', 'User successfully created!');
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
    public function edit(User $user)
    {
        return view('pages.admin.user.edit', [
            'user' => $user,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,  User $user)
    {
        $rules = [
            'name' => 'required|string|max:50',
            'roles' => 'nullable|string|in:ADMIN,USER',
        ];

        if ($request->email != $user->email) {
            $rules['email'] = 'required|email|unique:users';
        }

        $data = $request->validate($rules);
    
        if ($request->password) {
            $data['password'] = bcrypt($request->password);
        }else{
            unset($data['password']);
        }

        User::where('id', $user->id)->update($data);

        return redirect()->route('user.index')->with('success', 'User successfully updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        User::destroy($user->id);
        return redirect()->route('user.index')->with('success', 'User successfully deleted!');
    }
}
