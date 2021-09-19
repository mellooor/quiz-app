<div id="delete-quiz-modal-background" class="absolute top-0 left-0 bottom-0 right-0 flex flex-col justify-center items-center w-full bg-black bg-opacity-70" x-show="deleteQuizModalOpen">
    <div id="delete-quiz-modal-container" class="w-2/3 bg-white p-5" x-show="deleteQuizModalOpen">
        <h1 class="mb-5 text-2xl lg:text-4xl text-center">Delete Quiz</h1>
        <h3 class="mb-5 text-lg lg:text-2xl text-center">Are you sure you want to delete the quiz - "{{ $data['quiz']->title }}"?</h3>
        <div id="delete-quiz-modal-btns-container" class="xl:flex xl:justify-evenly">
            <button id="delete-quiz-btn-cancel" class="border w-full xl:w-1/3 p-3 sm:py-4 lg:py-6 xl:py-4 xl:px-2 mb-2 lg:mb-6 xl:mb-0 block rounded bg-gray-500 hover:bg-gray-700 text-gray-50 lg:text-2xl shadow-md" @click="deleteQuizModalOpen = false" type="button">Cancel</button>
            <button class="border w-full xl:w-1/3 p-3 sm:py-4 lg:py-6 xl:py-4 xl:px-2 mb-2 lg:mb-6 xl:mb-0 block rounded bg-red-500 hover:bg-red-700 text-red-50 lg:text-2xl shadow-md" type="submit">Delete</button>
        </div>
    </div>
</div>
