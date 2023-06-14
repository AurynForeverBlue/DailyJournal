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
use App\Http\Requests\UpdatePfphotoRequest;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

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
     * @param AuthenticateUserRequest $request
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
     * @param CreateUserRequest $request
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
     * @param UpdateEmailRequest $request
     */
    public function updateEmail(UpdateEmailRequest $request)
    {
        $request_data = $request->validated();
        $database_user = Auth::user();

        if (Hash::check($database_user["email"], $request_data["email"])) {
            return redirect("/")->back()->with('succes', "Can't update e-mail to current username");
        }
        
        $encrypted_email = bcrypt($request_data["email"]);

        UpdateUserJob::dispatch("email", $database_user, $encrypted_email);
        return redirect("/")->with('succes', "E-mail updated successfully");
    }

    /**
     * Update the specified user username in database
     * @param UpdateUsernameRequest $request
     */
    public function updateUsername(UpdateUsernameRequest $request)
    {
        $request_data = $request->validated();
        $database_user = Auth::user();
        
        if ($database_user["username"] == $request_data["username"]) {
            return redirect("/")->back()->with('succes', "Can't update e-mail to current username");
        }

        UpdateUserJob::dispatch("username", $database_user, $request_data["username"]);
        return redirect("/")->with('succes', "Username updated successfully");
    }

    /**
     * Update the specified user password in database
     * @param UpdatePasswordRequest $request
     */
    public function updatePassword(UpdatePasswordRequest $request)
    {
        $request_data = $request->validated();
        $database_user = Auth::user();

        if (Hash::check($database_user["password"], $request_data["password"])) {
            return redirect("/")->back()->with('succes', "Can't update e-mail to current username");
        }

        $encrypted_password = bcrypt($request_data["password"]);

        UpdateUserJob::dispatch("password", $database_user, $encrypted_password);
        return redirect("/")->with('succes', "Password updated successfully");
    }
        
    /**
     * Update the specified user profile photo in database
     * @param UpdatePfphotoRequest $request
     */
    public function updatePfphoto(UpdatePfphotoRequest $request)
    {
        $request_data = $request->validated();
        $database_user = Auth::user();
        
        $file = $request->file("pfphoto");
        $file_name = $database_user["username"] .'.'. $file->getClientOriginalExtension();
        
        Storage::disk('public')->put("pfphoto/". $file_name, file_get_contents($file));

        return redirect("/")->with('succes', "Profile photo updated successfully");
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
