@extends('app')

@section('title', 'Update Profile information')

@section('content')
    <div id="update-profile-panel-container" class="bg-gray-200 min-w-screen min-h-screen border-2 flex justify-center items-center">
        <div id="update-profile-panel" class="bg-gradient-to-br from-gray-100 to-white w-10/12 xl:w-1/2 bg-opacity-70 py-5 lg:py-7 px-10 flex flex-col shadow-xl rounded">
            <h1 class="mb-5 text-2xl lg:text-4xl text-center">Update Profile Information</h1>

            @if (session('status'))
                @if (session('status') === 'profile-information-updated')
                    <p class="text-green-500 mb-2">Your Profile Information has Been Successfully Updated.</p>
                @elseif (session('status') === 'password-updated')
                    <p class="text-green-500 mb-2">Your Password has Been Successfully Updated.</p>
                @endif
            @elseif ($errors->updateProfileInformation->any() || $errors->updatePassword->any())
                <div class="text-red-500">
                    <ul class="list-disc mb-2">
                        @if ($errors->updateProfileInformation->any())
                            @foreach ($errors->updateProfileInformation->all() as $error)
                                <li class="list-inside">{{ $error }}</li>
                            @endforeach
                        @elseif ($errors->updatePassword->any())
                            @foreach ($errors->updatePassword->all() as $error)
                                <li class="list-inside">{{ $error }}</li>
                            @endforeach
                        @endif
                    </ul>
                </div>
            @endif

            <div class="mb-2" id="update-profile-form-container" x-data="{ open: true}">
                <form action="{{ route('user-profile-information.update') }}" method="post" class="mb-2" x-show="open">
                    @csrf
                    @method('PUT')
                    <div id="email-container" class="flex flex-col mb-4">
                        <label for="email" class="mb-2 lg:text-2xl">Email Address:</label>
                        <input type="email" name="email" id="email" value="{{ $user->email }}" class="mb-1 border border-gray-200 lg:text-2xl"/>
                    </div>
                    <div id="name-container" class="flex flex-col mb-4">
                        <label for="name" class="mb-2 lg:text-2xl">Name:</label>
                        <input type="text" name="name" id="name" value="{{ $user->name }}" class="mb-1 border border-gray-200 lg:text-2xl"/>
                    </div>
                    <div id="btns-container" class="xl:flex xl:justify-evenly">
                        <button class="border w-full xl:w-1/3 p-6 sm:py-4 lg:py-6 xl:py-4 xl:px-2 mb-2 lg:mb-6 xl:mb-0 block rounded bg-yellow-500 hover:bg-yellow-700 text-yellow-50 lg:text-2xl shadow-md text-center" type="button" @click="open = ! open" @click.prevent>Update Password</button>
                        <button class="border w-full xl:w-1/3 p-6 sm:py-4 lg:py-6 xl:py-4 xl:px-2 mb-2 lg:mb-6 xl:mb-0 block rounded bg-blue-500 hover:bg-blue-700 text-blue-50 lg:text-2xl shadow-md" type="submit">Submit</button>
                    </div>
                </form>
                <form action="{{ route('user-password.update') }}" method="post" class="mb-2" x-show="!open">
                    @csrf
                    @method('PUT')
                    <div id="current-password-container" class="flex flex-col mb-4">
                        <label for="current_password" class="mb-2 lg:text-2xl">Current Password:</label>
                        <input type="password" name="current_password" id="current-password" class="mb-1 border border-gray-200 lg:text-2xl"/>
                    </div>
                    <div id="password-container" class="flex flex-col mb-4">
                        <label for="password" class="mb-2 lg:text-2xl">New Password:</label>
                        <input type="password" name="password" id="password" class="mb-1 border border-gray-200 lg:text-2xl"/>
                    </div>
                    <div id="password-confirmation-container" class="flex flex-col mb-4">
                        <label for="password_confirmation" class="mb-2 lg:text-2xl">Confirm New Password:</label>
                        <input type="password" name="password_confirmation" id="password-confirmation" class="mb-1 border border-gray-200 lg:text-2xl"/>
                    </div>
                    <div id="btns-container" class="xl:flex xl:justify-evenly">
                        <button class="border w-full xl:w-1/3 p-6 sm:py-4 lg:py-6 xl:py-4 xl:px-2 mb-2 lg:mb-6 xl:mb-0 block rounded bg-yellow-500 hover:bg-yellow-700 text-yellow-50 lg:text-2xl shadow-md text-center" type="button" @click="open = ! open" @click.prevent>Update Email/Password</button>
                        <button class="border w-full xl:w-1/3 p-6 sm:py-4 lg:py-6 xl:py-4 xl:px-2 mb-2 lg:mb-6 xl:mb-0 block rounded bg-blue-500 hover:bg-blue-700 text-blue-50 lg:text-2xl shadow-md" type="submit">Submit</button>
                    </div>
                </form>
                <form action="{{ route('delete-profile') }}" method="post" class="flex justify-center" x-data="{ deleteUserModalOpen: false}">
                    @csrf
                    @method('DELETE')
                    <button id="delete-user-btn" class="border w-full xl:w-1/3 p-6 sm:py-4 lg:py-6 xl:py-4 xl:px-2 mb-2 lg:mb-6 xl:mb-0 block rounded bg-red-500 hover:bg-red-700 text-red-50 lg:text-2xl shadow-md" @click="deleteUserModalOpen = ! deleteUserModalOpen" type="button">Delete Account</button>
                    <div id="delete-user-modal-background" class="absolute top-0 min-h-full flex flex-col justify-center items-center w-full bg-black bg-opacity-70" x-show="deleteUserModalOpen">
                        <div id="delete-user-modal-container" class="w-2/3 bg-white p-5" x-show="deleteUserModalOpen">
                            <p class="text-xl pb-5 text-red-500 font-bold">Are you sure that you want to delete your profile? Once deleted, you account cannot be restored.</p>
                            <div id="delete-user-modal-btns-container" class="xl:flex xl:justify-evenly">
                                <button id="delete-user-btn-cancel" class="border w-full xl:w-1/3 p-6 sm:py-4 lg:py-6 xl:py-4 xl:px-2 mb-2 lg:mb-6 xl:mb-0 block rounded bg-gray-500 hover:bg-gray-700 text-gray-50 lg:text-2xl shadow-md" @click="deleteUserModalOpen = false" type="button">Cancel</button>
                                <button class="border w-full xl:w-1/3 p-6 sm:py-4 lg:py-6 xl:py-4 xl:px-2 mb-2 lg:mb-6 xl:mb-0 block rounded bg-red-500 hover:bg-red-700 text-red-50 lg:text-2xl shadow-md" type="submit">Delete</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
