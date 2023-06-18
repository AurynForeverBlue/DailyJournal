<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Traits\Uuid;
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
use App\Jobs\UpdateFileJob;
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
        $userClass = new User();

        $user = $userClass->getUserWithUsername($input_data["username"]);

        if ($user) {
            if (Hash::check($input_data["password"], $user->password)) {
                Auth::login($user);
                return redirect("/")->with('succes', 'Welcome '. $input_data["username"].".");
            }
            else {
                return redirect()->back()->with('error', 'Username or password is incorrect.'); 
            }
        }
        else {
            return redirect()->back()->with('error', 'Username or password is incorrect.');
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
        $userClass = new User;

        $file_type = $userClass->createFileType();

        $new_user_data = [
            'user_id' => $this->createUuid(),
            'email' => $input_data['email'],
            'username' => $input_data['username'],
            'password' => bcrypt($input_data['password']),
            'file_type' => $file_type
        ];

        CreateUserJob::dispatch($new_user_data);

        return redirect("/login")->with('succes', 'Account has been created.');
    }

    /**
     * Display settings page
     */
    public function settings()
    {
        $userClass = new User();
        $database_user = $userClass->getCurrentUser();

        $current_user = [
            'email' => $database_user->email,
            'username' => $database_user->username,
            'file_type' => $database_user->file_type,
        ];

        return view('pages.users.update', [
            "current_user" => $current_user
        ]);
    }

    /**
     * Update the specified user email in database
     * @param UpdateEmailRequest $request
     */
    public function updateEmail(UpdateEmailRequest $request)
    {
        $request_data = $request->validated();
        $userClass = new User();

        $database_user = $userClass->getCurrentUser();

        if (Hash::check($database_user["email"], $request_data["email"])) {
            return redirect("/")->back()->with('succes', "Can't update e-mail to current username.");
        }

        UpdateUserJob::dispatch("email", $database_user, $request_data["email"]);
        return redirect("/")->with('succes', "E-mail updated successfully.");
    }

    /**
     * Update the specified user username in database
     * @param UpdateUsernameRequest $request
     */
    public function updateUsername(UpdateUsernameRequest $request)
    {
        $request_data = $request->validated();
        $userClass = new User();

        $database_user = $userClass->getCurrentUser();
        
        if ($database_user["username"] == $request_data["username"]) {
            return redirect("/")->back()->with('succes', "Can't update e-mail to current username");
        }

        UpdateUserJob::dispatch("username", $database_user, $request_data["username"]);
        return redirect("/")->with('succes', "Username updated successfully.");
    }

    /**
     * Update the specified user password in database
     * @param UpdatePasswordRequest $request
     */
    public function updatePassword(UpdatePasswordRequest $request)
    {
        $request_data = $request->validated();
        $userClass = new User();

        $database_user = $userClass->getCurrentUser();

        if (Hash::check($database_user["password"], $request_data["password"])) {
            return redirect("/")->back()->with('succes', "Can't update e-mail to current username");
        }

        $encrypted_password = bcrypt($request_data["password"]);

        UpdateUserJob::dispatch("password", $database_user, $encrypted_password);
        return redirect("/")->with('succes', "Password updated successfully.");
    }
        
    /**
     * Update the specified user profile photo in database
     * @param UpdatePfphotoRequest $request
     */
    public function updatePfphoto(UpdatePfphotoRequest $request)
    {
        $request->validated();
        $userClass = new User();

        $database_user = $userClass->getCurrentModelUser();
        $old_file_name = $userClass->getFileName();

        $file = $request->file("pfphoto");
        $file_name = $database_user["username"];
        $file_extension = $file->getClientOriginalExtension();
        $full_file_name = $file_name .".". $file_extension;

        $database_user->file_type = [
            "banner" => $database_user->file_type["banner"],
            "pfphoto" => $userClass->UpdateFileType($file_name, $file_extension),
        ];

        $database_user->save();

        $userClass->updateFile("public", "pfphoto/", $file, $full_file_name, $old_file_name);

        return redirect("/")->with('succes', "Profile photo updated successfully.");
    }

    /**
     * Update the specified user profile photo in database
     */
    public function deletePfphoto()
    {
        $userClass = new User();
        
        $database_user = $userClass->getCurrentModelUser();
        $old_filename = $userClass->getFileName();
        
        $database_user->file_type = [
            "pfphoto" => $userClass->UpdateFileType(),
            "banner" => $database_user->file_type["banner"],
        ];

        $database_user->save();

        $userClass->deleteFile("public", "pfphoto/", $old_filename);

        return redirect("/")->with('succes', "Profile photo deleted successfully.");
    }

    /**
     * Remove the specified user from database
     */
    public function destroy()
    {
        $userClass = new User();

        $user_data = [
            'user_id' => $userClass->getCurrentUser()->user_id,
        ];
        
        DeleteUserJob::dispatch($user_data);

        return redirect("/")->with('succes', 'Account has been deleted successfully.');
    }

    /**
     * logout user
     */
    public function logout()
    {
        Auth::logout();

        return redirect("/login")->with('succes', 'You have been logged out.');
    }
}