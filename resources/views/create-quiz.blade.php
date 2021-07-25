@extends('app')

@section('title', 'Create Quiz')

@section('content')
    <div id="create-quiz-panel-container" class="bg-gradient-to-r from-black to-indigo-300 via-indigo-800 min-w-screen h-screen flex justify-center items-center">
        <div id="create-quiz-panel" class="bg-gradient-to-br from-gray-100 to-white w-10/12 xl:w-1/2 bg-opacity-70 py-5 lg:py-7 px-10 flex flex-col shadow-xl rounded">
            <h1 class="mb-5 text-2xl lg:text-4xl text-center">Create a Quiz</h1>

            @if (session('status'))
                <p class="text-green-500 mb-2">{{ session('status') }}</p>
            @endif
            @if ($errors->any())
                <div class="text-red-500">
                    <ul class="list-disc mb-2">
                        @foreach ($errors->all() as $error)
                            <li class="list-inside">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('create-new-quiz') }}" method="post" class="mb-2 lg:mb-6 xl:mb-0">
                @csrf
                <div id="quiz-title-container" class="flex flex-col mb-4">
                    <label for="quiz-title" class="mb-2 lg:text-2xl">Quiz Name:</label>
                    <input type="text" name="title" id="quiz-title" class="border border-gray-200 lg:text-2xl"/>
                </div>
                <div id="quiz-topic-container" class="flex flex-col mb-4">
                    <label for="quiz-topic" class="mb-2 lg:text-2xl">Quiz Topic:</label>
                    <select name="topic_id" id="quiz-topic" class="border border-gray-200 lg:text-2xl">
                        <option selected value>No Topic</option>
                        @if ($topics)
                            @foreach ($topics as $topic)
                                <option value="{{ $topic->id }}">{{  $topic->topic }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>

                <button class="border w-1/3 xl:w-1/3 p-2 sm:py-4 lg:py-6 xl:py-4 mx-auto block rounded bg-green-500 hover:bg-green-700 text-green-50 lg:text-2xl shadow-md text-center" type="submit">Create Quiz</button>
            </form>
        </div>
    </div>
@endsection
