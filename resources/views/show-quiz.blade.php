@extends('app')

@section('content')
    <div id="question-container" class="flex-1 min-w-full bg-gradient-to-r from-black to-indigo-300 via-indigo-800 flex flex-col pt-10">
        <h1 class="text-white text-5xl text-center mb-5">{{ $quiz->title }}</h1>
        <div id="score" class="text-white text-4xl mx-auto mb-10">
            <p>Score: 0/10</p>
        </div>

        <div id="question" class="bg-indigo-50 bg-opacity-40 text-white font-bold w-4/5 mx-auto flex justify-center py-10 text-xl mb-10 rounded shadow-inner">
            <p>This is a question</p>
        </div>

        <div id="answers" class="w-4/6 xl:w-4/5 mx-auto mb-10 flex flex-col flex-nowrap flex-1 justify-evenly xl:justify-between xl:place-content-evenly">
            <button id="answer-1" class="bg-white hover:bg-indigo-500 bg-opacity-90 text-indigo-900 hover:text-white font-bold w-full xl:w-1/3 h-1/2 mx-auto py-10 flex justify-center mt-10 first:mt-0 rounded shadow-inner cursor-pointer">
                <p>Answer 1</p>
            </button>
            <button id="answer-2" class="bg-white hover:bg-indigo-500 bg-opacity-90 text-indigo-900 hover:text-white font-bold w-full xl:w-1/3 h-1/2 mx-auto py-10 flex justify-center mt-10 first:mt-0 rounded shadow-inner cursor-pointer">
                <p>Answer 2</p>
            </button>
            <button id="answer-3" class="bg-white hover:bg-indigo-500 bg-opacity-90 text-indigo-900 hover:text-white font-bold w-full xl:w-1/3 h-1/2 mx-auto py-10 flex justify-center mt-10 first:mt-0 rounded shadow-inner cursor-pointer">
                <p>Answer 3</p>
            </button>
            <button id="answer-4" class="bg-white hover:bg-indigo-500 bg-opacity-90 text-indigo-900 hover:text-white font-bold w-full xl:w-1/3 h-1/2 mx-auto py-10 flex justify-center mt-10 first:mt-0 rounded shadow-inner cursor-pointer">
                <p>Answer 4</p>
            </button>
            <button id="answer-5" class="bg-white hover:bg-indigo-500 bg-opacity-90 text-indigo-900 hover:text-white font-bold w-full xl:w-1/3 h-1/2 mx-auto py-10 flex justify-center mt-10 first:mt-0 rounded shadow-inner cursor-pointer">
                <p>Answer 5</p>
            </button>
            <button id="answer-6" class="bg-white hover:bg-indigo-500 bg-opacity-90 text-indigo-900 hover:text-white font-bold w-full xl:w-1/3 h-1/2 mx-auto py-10 flex justify-center mt-10 first:mt-0 rounded shadow-inner cursor-pointer">
                <p>Answer 6</p>
            </button>
        </div>
    </div>
@endsection
