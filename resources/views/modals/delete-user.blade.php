<div id="delete-user-modal-background" class="absolute top-0 min-h-full flex flex-col justify-center items-center w-full bg-black bg-opacity-70" x-show="deleteUserModalOpen">
    <div id="delete-user-modal-container" class="w-2/3 bg-white p-5" x-show="deleteUserModalOpen">
        <p class="text-xl pb-5 text-red-500 font-bold">Are you sure that you want to delete your profile? Once deleted, you account cannot be restored.</p>
        <div id="delete-user-modal-btns-container" class="xl:flex xl:justify-evenly">
            <button id="delete-user-btn-cancel" class="border w-full xl:w-1/3 p-3 sm:py-4 lg:py-6 xl:py-4 xl:px-2 mb-2 lg:mb-6 xl:mb-0 block rounded bg-gray-500 hover:bg-gray-700 text-gray-50 lg:text-2xl shadow-md" @click="deleteUserModalOpen = false" type="button">Cancel</button>
            <button class="border w-full xl:w-1/3 p-3 sm:py-4 lg:py-6 xl:py-4 xl:px-2 mb-2 lg:mb-6 xl:mb-0 block rounded bg-red-500 hover:bg-red-700 text-red-50 lg:text-2xl shadow-md" type="submit">Delete</button>
        </div>
    </div>
</div>
