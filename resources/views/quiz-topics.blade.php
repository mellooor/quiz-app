@extends('app')

@section('title', 'Quiz Topics')

@section('content')
    <div id="quiz-topics-panel-container" class="bg-gradient-to-r from-black to-indigo-300 via-indigo-800 min-w-screen h-screen flex justify-center items-center">
        <div id="quiz-topics-panel" class="bg-gradient-to-br from-gray-100 to-white bg-opacity-70 shadow-xl rounded box-content py-5 lg:py-7 px-10 w-2/3 h-2/3">
            <h1 class="mb-5 text-2xl lg:text-4xl text-center">Quiz Topics</h1>

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

            <div id="quiz-topics-container" class="flex flex-col w-full h-2/3 overflow-y-scroll border border-black">
                @if ($topics->isNotEmpty())
                    @foreach ($topics as $topic)
                        <div class="flex w-full justify-around items-center border-b py-2">
                            <div class="w-2/5">{{ $topic->topic }}</div>
                            <div>
                                <form action="{{ route('update-quiz-topic', $topic->id) }}" method="post" x-data="{ editQuizTopicModalOpen: false }">
                                    @csrf
                                    @method('PUT')
                                    <button type="button" id="edit-quiz-topic-btn" class="border p-3 mb-2 lg:mb-6 xl:mb-0 block rounded bg-yellow-500 hover:bg-yellow-700 text-yellow-50 lg:text-2xl shadow-md text-center" @click="editQuizTopicModalOpen = ! editQuizTopicModalOpen">Edit</button>
                                    @include('modals.update-quiz-topic')
                                </form>
                            </div>
                            <div>
                                <form action="{{ route('delete-quiz-topic', $topic->id) }}" method="post" x-data="{ deleteQuizTopicModalOpen: false }">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" id="delete-quiz-topic-btn" class="border p-3 mb-2 lg:mb-6 xl:mb-0 block rounded bg-red-500 hover:bg-red-700 text-red-50 lg:text-2xl shadow-md text-center" @click="deleteQuizTopicModalOpen = ! deleteQuizTopicModalOpen">Delete</button>
                                    @include('modals.delete-quiz-topic')
                                </form>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="flex w-full justify-around items-center border-b py-2">
                        <div class="w-full text-center">No topics to display</div>
                    </div>
                @endif
            </div>
            <form action="{{ route('create-quiz-topic') }}" method="post" class="flex justify-center mt-4" x-data="{ addQuizTopicModalOpen: false }">
                @csrf
                <button type="button" id="add-quiz-topic-btn" class="border p-3 mb-2 lg:mb-6 xl:mb-0 block rounded bg-green-500 hover:bg-green-700 text-green-50 lg:text-2xl shadow-md text-center" @click="addQuizTopicModalOpen = ! addQuizTopicModalOpen">Add Topic</button>
                @include('modals.create-quiz-topic')
            </form>
        </div>
    </div>
@endsection
