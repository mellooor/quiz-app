<nav class="flex py-2 flex-wrap bg-blue-100 border-gray-300 items-center relative" x-data="{ mainNavOpen: false }">
    <div id="nav-logo" class="w-1/2 order-2 pr-5 lg:w-auto lg:pl-5">
        <svg class="fill-current h-8 w-8 mr-2" width="54" height="54" viewBox="0 0 54 54" xmlns="http://www.w3.org/2000/svg"><path d="M13.5 22.1c1.8-7.2 6.3-10.8 13.5-10.8 10.8 0 12.15 8.1 17.55 9.45 3.6.9 6.75-.45 9.45-4.05-1.8 7.2-6.3 10.8-13.5 10.8-10.8 0-12.15-8.1-17.55-9.45-3.6-.9-6.75.45-9.45 4.05zM0 38.3c1.8-7.2 6.3-10.8 13.5-10.8 10.8 0 12.15 8.1 17.55 9.45 3.6.9 6.75-.45 9.45-4.05-1.8 7.2-6.3 10.8-13.5 10.8-10.8 0-12.15-8.1-17.55-9.45-3.6-.9-6.75.45-9.45 4.05z"/></svg>
    </div>
    <div id="nav-dropdown-btn" class="w-1/2 order-1 pl-5 lg:hidden">
        <svg class="fill-current h-7 w-7 cursor-pointer" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" @click="mainNavOpen = !mainNavOpen"><title>Menu</title><path d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z"/></svg>
    </div>
    <div id="nav-menu-items" :class="{ 'block' : mainNavOpen === true, 'hidden' : mainNavOpen === false }" class="w-full flex-1 order-3 lg:mt-0 lg:flex items-center justify-center border-b-2 absolute lg:relative bg-blue-100 border-gray-300 lg:border-0 top-full" @click.away="mainNavOpen = false">

        @auth
        <div id="quizzes-menu-item-container" class="mb-2 lg:mr-5 w-full lg:w-auto lg:flex lg:relative" x-data="{ quizzesNavOpen: false }">
            <a href="#" class="block hover:bg-blue-50 lg:hover:bg-blue-100 text-lg border-black w-full p-2 lg:hover:text-white" :class="{ 'bg-blue-300': quizzesNavOpen, 'hover:bg-blue-300' : quizzesNavOpen }" @click.prevent="quizzesNavOpen = true">Quizzes:</a>
            <div id="quizzes-sub-menu-items-container" class="lg:absolute lg:top-full lg:flex lg:flex-col">
                <a href="{{ route('all-quizzes') }}" class="block bg-blue-50 hover:bg-white text-lg border-black w-full py-2 px-5" x-show="quizzesNavOpen" @click.away="quizzesNavOpen = false">All Quizzes</a>
                <a href="{{ route('quizzes-by-user', Auth::user()->id) }}" class="block bg-blue-50 hover:bg-white text-lg border-black w-full py-2 px-5" x-show="quizzesNavOpen" @click.away="quizzesNavOpen = false">My Quizzes</a>
            </div>
        </div>
        @endauth

        @guest
            <div id="quizzes-menu-item-container" class="mb-2 lg:mr-5 w-full lg:w-auto lg:flex" x-data="{ quizzesNavOpen: false }">
                <a href="#" class="block hover:bg-blue-50 lg:hover:bg-blue-100 text-lg border-black w-full p-2 lg:hover:text-white">Quizzes</a>
            </div>
        @endguest

        @auth
            <div id="create-quiz-menu-item-container" class="mb-2 lg:mr-5">
                <a href="{{ route('new-quiz') }}" class="block hover:bg-blue-50 lg:hover:bg-blue-100 text-lg border-black w-full p-2 lg:hover:text-white">Create a Quiz</a>
            </div>

            @if (\Illuminate\Support\Facades\Auth::user()->isAdmin())
                    <div id="quiz-topics-item-container" class="mb-2 lg:mr-5">
                        <a href="{{ route('quiz-topics') }}" class="block hover:bg-blue-50 lg:hover:bg-blue-100 text-lg border-black w-full p-2 lg:hover:text-white">Quiz Topics</a>
                    </div>
            @endif

            <div id="my-account-menu-item-container" class="mb-2 lg:mr-5">
                <a href="{{ route('update-profile') }}" class="block hover:bg-blue-50 lg:hover:bg-blue-100 text-lg border-black w-full p-2 lg:hover:text-white">My Account</a>
            </div>

            <div id="logout-menu-item-container" class="mb-2 lg:last:ml-auto lg:mr-5">
                <form action="{{ route("logout") }}" method="post">
                    @csrf
                    <button type="submit" class="block hover:bg-blue-50 lg:hover:bg-blue-100 text-lg border-black w-full p-2 lg:hover:text-white">Logout</button>
                </form>
            </div>
        @endauth

        @guest
            <div id="sign-in-register-menu-item-container" class="mb-2 lg:last:ml-auto lg:mr-5">
                <a href="{{ route("login") }}" class="block hover:bg-blue-50 lg:hover:bg-blue-100 text-lg border-black w-full p-2 lg:hover:text-white">Sign in/Register</a>
            </div>
        @endguest

    </div>
</nav>
