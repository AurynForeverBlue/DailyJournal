@extends('layout')
@section('js')
    <script src="./js/modelBox.js"></script>
@endsection
@section('main')
    <div id="settings_wrapper">
        <div id="settings_container">
            <div id="settings_usercontainer">
                <div class="banner">
                    <img src="{{ asset('storage/banner/' . $banner_data["file_name"] .".". $banner_data["file_type"]) }}" alt="{{ $current_user["username"] }}-banner">
                </div>
                <div id="settings_user_pfp">
                    <img src="{{ asset('storage/pfphoto/' . $pfphoto_data["file_name"] .".". $pfphoto_data["file_type"]) }}" alt="{{ $current_user["username"] }}-pfp">
                </div>
                <div id="settings_user_data">
                    <h2>{{ $current_user["username"] }}</h2>
                    <h3>{{ $current_user["email"] }}</h3>
                </div>
            </div>
            <div class="settings_form">
                <button class="btn" id="btnModal4">Update Profile Photo</button>
                @if ($pfphoto_data["file_name"] != "standard")
                    <a href="/delete/user/pfphoto"><button class="btn">Remove Profile Photo</button></a>
                @endif
                <br>

                <input type="email" name="" id="" value="{{ $current_user["email"] }}" disabled>
                <button class="btn" id="btnModal1">Update Email</button><br>
                
                <input type="text" name="" id="" value="{{ $current_user["username"] }}" disabled>
                <button class="btn" id="btnModal2">Update Username</button><br>
                
                <input type="password" name="" id="" value="secret_password" disabled>
                <button class="btn" id="btnModal3">Update Password</button><br>
            </div>
        </div>
    </div>

    <div id="modal_update_email" class="modal">
        <div class="modal-content">
            <h4>New E-mail</h4>
            @include('components.users.updateEmail')
        </div>
    </div>

    <!-- Modal 2 -->
    <div id="modal_update_username" class="modal">
        <div class="modal-content">
            <h4>New Username</h4>
            @include('components.users.updateUsername')
        </div>
    </div>

    <!-- Modal 3 -->
    <div id="modal_update_password" class="modal">
        <div class="modal-content">
            <h4>New Password</h4>
            @include('components.users.updatePassword')
        </div>
    </div>

    <!-- Modal 4 -->
    <div id="modal_update_pfphoto" class="modal">
        <div class="modal-content">
            <h4>New Profile Photo</h4>
            @include('components.users.updatePfPhoto')
        </div>
    </div>
@endsection