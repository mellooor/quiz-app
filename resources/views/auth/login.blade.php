@extends('app')

@section('title', 'Login')

@section('content')
    <div id="login-panel-container" class="flex-1 bg-gradient-to-r from-black to-indigo-300 via-indigo-800 min-w-screen flex-1 flex justify-center items-center">
        <div id="login-panel" class="bg-gradient-to-br from-gray-100 to-white w-10/12 xl:w-1/2 bg-opacity-70 py-5 lg:py-7 px-10 flex flex-col shadow-xl rounded">
            <h1 class="mb-5 text-2xl lg:text-3xl text-center">Login</h1>

            @if ($errors->any())
                <div class="text-red-500">
                    <ul class="list-disc mb-2">
                        @foreach ($errors->all() as $error)
                            <li class="list-inside">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form class="mb-2" action="{{ route("login") }}" method="post">
                @csrf
                <div id="email-container" class="flex flex-col mb-4">
                    <label for="email" class="mb-2 lg:text-xl">Email:</label>
                    <input type="email" name="email" id="email" class="border border-gray-200 lg:text-xl"/>
                </div>
                <div id="password-container" class="flex flex-col mb-6 lg:mb-8">
                    <label for="password" class="mb-2 lg:text-xl">Password:</label>
                    <input type="password" name="password" id="password" class="mb-1 border border-gray-200 lg:text-xl"/>
                    <a href="{{ route("password.request") }}" class="text-sm lg:text-lg text-center text-blue-900 underline">Forgot Password?</a>
                </div>
                <div id="login-btns" class="xl:flex xl:justify-evenly">
                    <a href="{{ route("register") }}" class="border w-full xl:w-1/3 p-2 sm:py-4 lg:py-6 xl:py-4 mb-2 lg:mb-6 xl:mb-0 block rounded bg-blue-500 hover:bg-blue-700 text-blue-50 lg:text-xl shadow-md text-center">Register</a>
                    <button class="border w-full xl:w-1/3 p-2 sm:py-4 lg:py-6 xl:py-4 block rounded bg-green-500 hover:bg-green-700 text-green-100 lg:text-xl shadow-md" type="submit">Log In</button>
                </div>
            </form>
        </div>
    </div>
@endsection
