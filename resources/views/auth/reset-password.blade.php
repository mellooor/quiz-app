@extends('app')

@section('title', 'Reset Password')

@section('content')
    <div id="reset-password-panel-container" class="bg-gradient-to-r from-black to-indigo-300 via-indigo-800 min-w-screen min-h-screen flex justify-center items-center">
        <div id="reset-password-panel" class="bg-gradient-to-br from-gray-100 to-white w-10/12 xl:w-1/2 bg-opacity-70 py-5 lg:py-7 px-10 flex flex-col shadow-xl rounded">
            <h1 class="mb-5 text-2xl lg:text-3xl text-center">Reset Password</h1>

            @if ($errors->any())
                <div class="text-red-500">
                    <ul class="list-disc mb-2 text-red-500">
                        @foreach ($errors->all() as $error)
                            <li class="list-inside">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form class="mb-2" action="{{ route("password.update") }}" method="post">
                @csrf
                <div id="token-container">
                    <input type="hidden" name="token" id="token" value="{{ request()->route('token') }}"/>
                </div>
                <div id="email-container">
                    <input type="hidden" name="email" id="email"value="{{ request()->query('email') }}"/>
                </div>
                <div id="password-container" class="flex flex-col mb-4">
                    <label for="password" class="mb-2 lg:text-xl">New Password:</label>
                    <input type="password" name="password" id="password" class="mb-1 border border-gray-200 lg:text-xl"/>
                </div>
                <div id="confirm-password-container" class="flex flex-col mb-6 lg:mb-8">
                    <label for="password_confirmation" class="mb-2 lg:text-xl">Confirm Password:</label>
                    <input type="password" name="password_confirmation" id="confirm-password" class="mb-1 border border-gray-200 lg:text-xl"/>
                </div>
                <div id="login-btns" class="xl:flex xl:justify-evenly">
                    <button class="border w-full xl:w-1/3 p-2 sm:py-4 lg:py-6 xl:py-4 mb-2 lg:mb-6 xl:mb-0 block rounded bg-blue-500 hover:bg-blue-700 text-blue-50 lg:text-2xl shadow-md" type="submit">Submit</button>
                </div>
            </form>
        </div>
    </div>
@endsection
