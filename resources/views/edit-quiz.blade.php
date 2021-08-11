@extends('app')

@section('title', 'Edit Quiz')

@section('content')
    <div id="edit-quiz-panel-container" class="bg-gray-200 min-w-screen min-h-screen border-2 flex flex-col justify-center items-center">
        <div id="edit-quiz-primary-panel" class="bg-gradient-to-br from-gray-100 to-white w-10/12 xl:w-1/2 bg-opacity-70 py-5 lg:py-7 px-10 mb-10 flex flex-col shadow-xl rounded">
            <h1 class="mb-5 text-2xl lg:text-4xl text-center">Edit Quiz</h1>

            @if (session()->has('status'))
                @if (session('status'))
                    <p class="text-green-500 mb-2">{{ session('status') }}</p>
                @endif
            @elseif ($errors->any())
                <div class="text-red-500">
                    <ul class="list-disc mb-2">
                        @foreach ($errors->all() as $error)
                            <li class="list-inside">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('update-quiz', $data['quiz']->id) }}" method="post" class="mb-2 lg:mb-6 xl:mb-0">
                @csrf
                @method('PUT')
                <div id="quiz-title-container" class="flex flex-col mb-4">
                    <label for="quiz_title" class="mb-2 lg:text-2xl">Quiz Title:</label>
                    <input type="text" name="title" id="quiz-title" class="border border-gray-200 lg:text-2xl" value="{{ $data['quiz']->title }}"/>
                </div>
                <div id="quiz-topic-container" class="flex flex-col mb-4">
                    <label for="quiz-topic" class="mb-2 lg:text-2xl">Quiz Topic:</label>
                    <select name="topic_id" id="quiz-topic" class="border border-gray-200 lg:text-2xl">
                        <option {{ $data['quiz']->topic_id ? '' : 'selected' }} value>No Topic</option>
                        @if ($data['topics'])
                            @foreach ($data['topics'] as $topic)
                                <option {{ $data['quiz']->topic_id === $topic->id ? 'selected' : '' }} value="{{ $topic->id }}">{{  $topic->topic }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>

                <button class="border w-2/3 md:w-1/3 p-4 lg:py-6 xl:py-4 mx-auto block rounded bg-green-500 hover:bg-green-700 text-green-50 lg:text-2xl shadow-md text-center" type="submit">Update</button>
            </form>
        </div>
        <div id="edit-quiz-secondary-panel" class="bg-gradient-to-br from-gray-100 to-white w-10/12 xl:w-1/2 bg-opacity-70 py-5 lg:py-7 px-10 flex justify-center shadow-xl rounded">
            <a href="{{ route('create-quiz-questions', $data['quiz']->id) }}" class="border w-2/3 md:w-1/3 p-4 lg:py-6 xl:py-4 block rounded bg-yellow-500 hover:bg-yellow-700 text-yellow-50 lg:text-2xl shadow-md text-center">Edit Questions</a>
        </div>
    </div>
@endsection
