<nav class=" bg-sky-600">
    <div class="flex flex-wrap justify-between items-center mx-auto max-w-screen-xl p-4">
        <a href="{{ route('publication.index') }}" class="flex items-center space-x-3 rtl:space-x-reverse">
            <img src="{{ asset('img/logo-bg-remove.png') }}" class=" h-16 rounded-full" alt="Logo" />
        </a>

        <ul class="flex flex-row font-medium mt-0 space-x-8 rtl:space-x-reverse text-sm">
            <li>
                <a href="{{ route('publication.index') }}" class="text-heading hover:underline"
                    aria-current="page">Home</a>
            </li>
            @auth
                <li>
                    <a href="{{ route('project.index') }}" class="text-heading hover:underline"
                        aria-current="page">Profilo</a>
                </li>
            @endauth
        </ul>

        <div class="flex items-center space-x-6 rtl:space-x-reverse">
            <a href="{{ route('login') }}" class="text-sm font-medium text-fg-brand hover:underline">Accedi</a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100 font-bold">
                    Disconnetti
                </button>
            </form>
        </div>


    </div>
</nav>
