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
