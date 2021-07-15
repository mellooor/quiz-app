<div id="delete-quiz-topic-modal-background" class="absolute top-0 left-0 min-h-full flex flex-col justify-center items-center w-full bg-black bg-opacity-70" x-show="deleteQuizTopicModalOpen">
    <div id="delete-quiz-topic-modal-container" class="w-2/3 bg-white p-5" x-show="deleteQuizTopicModalOpen">
        <h1 class="mb-5 text-2xl lg:text-4xl text-center">Delete Quiz Topic</h1>
        <h3 class="mb-5 text-lg lg:text-2xl text-center">Are you sure you want to delete the topic - "{{ $topic->topic }}"?</h3>
        <div id="delete-quiz-topic-modal-btns-container" class="xl:flex xl:justify-evenly">
            <button id="delete-quiz-topic-btn-cancel" class="border w-full xl:w-1/3 p-3 sm:py-4 lg:py-6 xl:py-4 xl:px-2 mb-2 lg:mb-6 xl:mb-0 block rounded bg-gray-500 hover:bg-gray-700 text-gray-50 lg:text-2xl shadow-md" @click="deleteQuizTopicModalOpen = false" type="button">Cancel</button>
            <button class="border w-full xl:w-1/3 p-3 sm:py-4 lg:py-6 xl:py-4 xl:px-2 mb-2 lg:mb-6 xl:mb-0 block rounded bg-red-500 hover:bg-red-700 text-red-50 lg:text-2xl shadow-md" type="submit">Delete</button>
        </div>
    </div>
</div>
