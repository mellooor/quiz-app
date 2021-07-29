@extends('app')

@section('title', 'Forgot Password')

@section('content')
    <div id="forgot-password-panel-container" class="flex-1 bg-gradient-to-r from-black to-indigo-300 via-indigo-800 min-w-screen flex justify-center items-center">
        <div id="forgot-password-panel" class="bg-gradient-to-br from-gray-100 to-white w-10/12 xl:w-1/2 bg-opacity-70 py-5 lg:py-7 px-10 flex flex-col shadow-xl rounded">
            <h1 class="mb-5 text-2xl lg:text-3xl text-center">Forgot Password</h1>

            @if (session('status'))
                <p class="text-green-500">{{ session('status') }}</p>
            @elseif ($errors->any())
                <div class="text-red-500">
                    <ul class="list-disc mb-2">
                        @foreach ($errors->all() as $error)
                            <li class="list-inside">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @else
                <form class="mb-2" action="{{ route("password.request") }}" method="post">
                    @csrf
                    <div id="email-container" class="flex flex-col mb-4">
                        <label for="email" class="mb-2 lg:text-xl">Please Enter your Email Address:</label>
                        <input type="email" name="email" id="email" class="mb-1 border border-gray-200 lg:text-xl"/>
                    </div>
                    <div id="forgot-password-btns" class="xl:flex xl:justify-evenly">
                        <button class="border w-full xl:w-1/3 p-2 sm:py-4 lg:py-6 xl:py-4 mb-2 lg:mb-6 xl:mb-0 block rounded bg-blue-500 hover:bg-blue-700 text-blue-50 lg:text-xl shadow-md" type="submit">Submit</button>
                    </div>
                </form>
            @endif

        </div>
    </div>
@endsection
