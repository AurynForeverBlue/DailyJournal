<?php

namespace App\Http\Controllers;

use App\Traits\Uuid;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\AuthenticateUserRequest;
use App\Jobs\CreateUserJob;
use App\Jobs\DeleteUserJob;
use App\Models\Security;
use Illuminate\Support\Facades\Crypt;

class UserController extends Controller
{
    use Uuid;

    public function showlogin()
    {
        return view('pages.users.login');
    }

    public function authenticate(AuthenticateUserRequest $request)
    {
        $input_data = $request->validated();
        $user = User::where('username', $input_data["username"])->first();

        if ($user) {
            if (Hash::check($input_data["password"], $user->password)) {
                Auth::login($user);
                return redirect("/")->with('succes', 'Welcome '. $input_data["username"]);
            }
            else {
                return redirect()->back()->with('error', 'Username or password is incorrect'); 
            }
        }
        else {
            return redirect()->back()->with('error', 'Username or password is incorrect');
        }
    }

    public function showRegister()
    {
        return view('pages.users.register');
    }

    public function store(CreateUserRequest $request)
    {
        $input_data = $request->validated();

        $new_user_data = [
            'user_id' => $this->createUuid(),
            'email' => bcrypt($input_data['email']),
            'username' => $input_data['username'],
            'password' => bcrypt($input_data['password']),
        ];

        CreateUserJob::dispatch($new_user_data);

        return redirect("/login")->with('succes', 'Account has been created.');
    }

    public function destroy()
    {
        $user_data = [
            'journal_id' => Auth::user()->user_id,
        ];
        
        DeleteUserJob::dispatch($user_data);

        return redirect("/")->with('succes', 'Account has been created.');
    }

    public function logout()
    {
        Auth::logout();

        return redirect("/login")->with('succes', 'You have been logged out');
    }
}
