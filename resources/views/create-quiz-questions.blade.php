@extends('app')

@section('title', 'Create Quiz Questions')

@section('content')
    <div id="quiz-questions-panel-container" class="flex-1 bg-gradient-to-r from-black to-indigo-300 via-indigo-800 py-5 min-w-screen flex justify-center items-center">
        <div id="quiz-questions-panel" class="bg-gradient-to-br from-gray-100 to-white w-10/12 xl:w-1/2 bg-opacity-70 py-5 lg:py-7 px-10 flex flex-col shadow-xl rounded h-3/4 overflow-y-scroll">
            <a href="/" id="quiz-questions-back-btn" class="border w-1/2 sm:w-1/5 xl:w-1/3 mb-4 p-2 lg:py-6 xl:py-4 block rounded bg-gray-500 hover:bg-gray-700 text-gray-50 shadow-md text-center">Back to Quiz</a>
            <h1 class="mb-5 text-2xl lg:text-4xl mx-auto">Quiz Questions</h1>
            <p>2/10 Questions Used for {{ $quiz->title }} Quiz.</p>

            <div id="quiz-questions-container">
                <div class="quiz-question-container flex flex-wrap lg:flex-nowrap justify-around items-center mt-4 mb-4 border p-2">
                    <p class="font-bold mb-4 lg:mb-0">1</p>
                    <p class="w-full lg:w-2/3 mb-4 lg:mb-0">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean sed finibus nisl, tempus elementum urna. Phasellus porta scelerisque dui, vitae varius eros tempor vitae. Mauris eget nibh interdum, laoreet purus in, facilisis odio. Sed pellentesque auctor urna, bibendum aliquet odio.</p>
                    <div class="question-btns-container w-full lg:w-1/5 flex lg:flex-col justify-aroud">
                        <a href="/" class="border w-1/2 lg:w-full p-2 py-4 block rounded bg-yellow-500 hover:bg-yellow-700 text-yellow-50 shadow-md text-center">Edit</a>
                        <a href="/" class="border w-1/2 lg:w-full p-2 py-4 block rounded bg-red-500 hover:bg-red-700 text-red-50 shadow-md text-center">Delete</a>
                    </div>
                </div>
                <div class="quiz-question-container flex flex-wrap lg:flex-nowrap justify-around items-center mt-4 mb-4 border p-2">
                    <p class="font-bold mb-4 lg:mb-0">2</p>
                    <p class="w-full lg:w-2/3 mb-4 lg:mb-0">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean sed finibus nisl, tempus elementum urna. Phasellus porta scelerisque dui, vitae varius eros tempor vitae. Mauris eget nibh interdum, laoreet purus in, facilisis odio. Sed pellentesque auctor urna, bibendum aliquet odio.</p>
                    <div class="question-btns-container w-full lg:w-1/5 flex lg:flex-col justify-aroud">
                        <a href="/" class="border w-1/2 lg:w-full p-2 py-4 block rounded bg-yellow-500 hover:bg-yellow-700 text-yellow-50 shadow-md text-center">Edit</a>
                        <a href="/" class="border w-1/2 lg:w-full p-2 py-4 block rounded bg-red-500 hover:bg-red-700 text-red-50 shadow-md text-center">Delete</a>
                    </div>
                </div>
                <a href="/" class="border w-1/2 sm:w-1/5 xl:w-1/3 mx-auto p-3 lg:py-6 xl:py-4 block rounded bg-green-500 hover:bg-green-700 text-green-50 shadow-md text-center">Add Question</a>
            </div>
        </div>
    </div>
@endsection
