<div class="flex-1 w-screen bg-gradient-to-r from-black to-indigo-300 via-indigo-800">
    <h1 class="my-5 text-center text-3xl text-white">{{  $data['title'] }}</h1>

    <div class="quiz-items-container w-full h-full flex flex-col justify-center items-center rounded mt-20">
        @if (session()->has('status'))
            @if (session('status'))
                <p class="text-green-500 mb-2">{{ session('status') }}</p>
            @endif
        @endif

        @if ($data['quizzes']->isEmpty())
            <div class="no-quizzes-to-display-container w-2/3 h-1/6 flex flex-col bg-gray-200 shadow-xl mb-5 rounded">
                <p class="text-center text-xl">No Quizzes to Display</p>
            </div>
        @else

        @endif

        @foreach ($data['quizzes'] as $quiz)
            <div class="quiz-item w-2/3 h-1/6 flex flex-col bg-gray-200 shadow-xl mb-5 rounded">
                <div class="quiz-container-header bg-indigo-900 bg-opacity-50 rounded text-white p-2">
                    <p class="text-center text-2xl">{{ $quiz->title }}</p>
                </div>
                <div class="quiz-container-body w-full flex-1 flex items-center p-3">
                    <ul>
                        <li class="flex mb-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Created on {{ $quiz->created_at }}
                        </li>

                        @if ($quiz->topic)
                            <li class="flex mb-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                                </svg>
                                {{ $quiz->topic->topic }}
                            </li>
                        @endif

                        <li class="flex">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            10 Questions
                        </li>
                    </ul>
                </div>
                <div class="quiz-container-btns flex flex-col sm:flex-row sm:justify-around mx-4 sm:mx-0 mb-4 text-center">
                    <a href="{{ route('quiz', $quiz->id) }}" class="quiz-container-play-btn p-3 mb-2 sm:mb-0 bg-green-600 hover:bg-green-800 text-gray-50 text-xl rounded">Play</a>
                    @if ($quiz->author_id === Auth::user()->id)
                        <a href="{{ route('edit-quiz', $quiz->id) }}" class="quiz-container-edit-btn p-3 mb-2 sm:mb-0 bg-yellow-600 hover:bg-yellow-800 text-yellow-50 text-xl rounded">Edit</a>
                    @endif
                </div>
            </div>
        @endforeach

        {{ $data['quizzes']->links() }}
    </div>
</div>
