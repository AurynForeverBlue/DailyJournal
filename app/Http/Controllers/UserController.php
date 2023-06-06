<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Traits\Uuid;
use App\Models\Security;
use App\Jobs\CreateUserJob;
use App\Jobs\DeleteUserJob;
use App\Jobs\UpdateUserJob;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\UpdateEmailRequest;
use App\Http\Requests\UpdatePasswordRequest;
use App\Http\Requests\UpdateUsernameRequest;
use App\Http\Requests\AuthenticateUserRequest;

class UserController extends Controller
{
    use Uuid;

    /**
     * Display login page
     */
    public function showlogin()
    {
        return view('pages.users.login');
    }

    /**
     * Login user
     */
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

    /**
     * Display register page
     */
    public function showRegister()
    {
        return view('pages.users.register');
    }

    /**
     * Store a newly created User in the database
     */
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

    /**
     * Display settings page
     */
    public function settings()
    {
        $security = new Security();
        $decrypted_user_data = [
            'email' => Auth::user()->email,
            'username' => Auth::user()->username,
            'password' => Auth::user()->password,
        ];

        return view('pages.users.update', [
            "current_user" => $decrypted_user_data
        ]);
    }

    /**
     * Update the specified user email in database
     */
    public function updateEmail(UpdateEmailRequest $request)
    {
        $request_data = $request->validated();
        $database_user = Auth::user();
        $updated_item = "email";

        if (Hash::check($database_user["email"], $request_data["email"])) {
            return redirect("/")->back()->with('succes', "Can't update e-mail to current username");
        }

        UpdateUserJob::dispatch();
        return redirect("/")->with('succes', "");
    }

    /**
     * Update the specified user username in database
     */
    public function updateUsername(UpdateUsernameRequest $request)
    {
        $request_data = $request->validated();
        $database_user = Auth::user();
        $updated_item = "username";

        if ($database_user["username"] == $request_data["username"]) {
            return redirect("/")->back()->with('succes', "Can't update e-mail to current username");
        }

        UpdateUserJob::dispatch();
        return redirect("/")->with('succes', "");
    }

    /**
     * Update the specified user password in database
     */
    public function updatePassword(UpdatePasswordRequest $request)
    {
        $request_data = $request->validated();
        $database_user = Auth::user();
        $updated_item = "password";

        if (Hash::check($database_user["password"], $request_data["password"])) {
            return redirect("/")->back()->with('succes', "Can't update e-mail to current username");
        }

        UpdateUserJob::dispatch();
        return redirect("/")->with('succes', "");
    }

    /**
     * Remove the specified user from database
     */
    public function destroy()
    {
        $user_data = [
            'journal_id' => Auth::user()->user_id,
        ];
        
        DeleteUserJob::dispatch($user_data);

        return redirect("/")->with('succes', 'Account has been created.');
    }

    /**
     * logout user
     */
    public function logout()
    {
        Auth::logout();

        return redirect("/login")->with('succes', 'You have been logged out');
    }
}
