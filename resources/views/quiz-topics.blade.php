@extends('app')

@section('title', 'Quiz Topics')

@section('content')
    <div id="quiz-topics-panel-container" class="bg-gray-200 min-w-screen h-screen border-2 flex justify-center items-center">
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
                                    <div id="edit-quiz-topic-modal-background" class="absolute top-0 left-0 min-h-full flex flex-col justify-center items-center w-full bg-black bg-opacity-70" x-show="editQuizTopicModalOpen">
                                        <div id="edit-quiz-topic-modal-container" class="w-2/3 bg-white p-5" x-show="editQuizTopicModalOpen">
                                            <h1 class="mb-5 text-2xl lg:text-4xl text-center">Edit Quiz Topic</h1>
                                            <div id="topic-container" class="flex flex-col mb-4">
                                                <label for="topic" class="mb-2 lg:text-2xl">Topic:</label>
                                                <input type="text" name="topic" id="topic" class="mb-1 border border-gray-200 lg:text-2xl" value="{{ $topic->topic }}"/>
                                            </div>
                                            <div id="edit-quiz-topic-modal-btns-container" class="xl:flex xl:justify-evenly">
                                                <button id="edit-quiz-topic-btn-cancel" class="border w-full xl:w-1/3 p-3 sm:py-4 lg:py-6 xl:py-4 xl:px-2 mb-2 lg:mb-6 xl:mb-0 block rounded bg-gray-500 hover:bg-gray-700 text-gray-50 lg:text-2xl shadow-md" @click="editQuizTopicModalOpen = false" type="button">Cancel</button>
                                                <button class="border w-full xl:w-1/3 p-3 sm:py-4 lg:py-6 xl:py-4 xl:px-2 mb-2 lg:mb-6 xl:mb-0 block rounded bg-yellow-500 hover:bg-yellow-700 text-yellow-50 lg:text-2xl shadow-md" type="submit">Update</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div>
                                <form action="/" method="post">
                                    <button type="submit" class="border p-3 mb-2 lg:mb-6 xl:mb-0 block rounded bg-red-500 hover:bg-red-700 text-red-50 lg:text-2xl shadow-md text-center">Delete</button>
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
                <div id="add-quiz-topic-modal-background" class="absolute top-0 left-0 min-h-full flex flex-col justify-center items-center w-full bg-black bg-opacity-70" x-show="addQuizTopicModalOpen">
                    <div id="add-quiz-topic-modal-container" class="w-2/3 bg-white p-5" x-show="addQuizTopicModalOpen">
                        <h1 class="mb-5 text-2xl lg:text-4xl text-center">Add Quiz Topic</h1>
                        <div id="topic-container" class="flex flex-col mb-4">
                            <label for="topic" class="mb-2 lg:text-2xl">Topic:</label>
                            <input type="text" name="topic" id="topic" class="mb-1 border border-gray-200 lg:text-2xl"/>
                        </div>
                        <div id="add-quiz-topic-modal-btns-container" class="xl:flex xl:justify-evenly">
                            <button id="add-quiz-topic-btn-cancel" class="border w-full xl:w-1/3 p-3 sm:py-4 lg:py-6 xl:py-4 xl:px-2 mb-2 lg:mb-6 xl:mb-0 block rounded bg-gray-500 hover:bg-gray-700 text-gray-50 lg:text-2xl shadow-md" @click="addQuizTopicModalOpen = false" type="button">Cancel</button>
                            <button class="border w-full xl:w-1/3 p-3 sm:py-4 lg:py-6 xl:py-4 xl:px-2 mb-2 lg:mb-6 xl:mb-0 block rounded bg-green-500 hover:bg-green-700 text-green-50 lg:text-2xl shadow-md" type="submit">Add</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
