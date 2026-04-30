<nav x-data="{ open: false }" class="bg-gray-900 h-screen fixed top-0 left-0 w-64 overflow-y-auto z-50">
    <div class="p-4">
        <div class="flex items-center gap-3 mb-8">
            <span class="text-2xl text-white font-bold">App mission</span>
        </div>

        <div class="space-y-1">
            <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                <span class="mr-3">🏠</span>
                {{ __('Dashboard') }}
            </x-nav-link>

            <x-nav-link :href="route('missions.index')" :active="request()->routeIs('missions.*')">
                <span class="mr-3">🚀</span>
                {{ __('Missions') }}
            </x-nav-link>

            @hasanyrole('operateur|validateur')
                <x-nav-link :href="route('vehicules.index')" :active="request()->routeIs('vehicules.*')">
                    <span class="mr-3">🚗</span>
                    {{ __('Véhicules') }}
                </x-nav-link>
            @endhasanyrole

            <div class="pt-4 pb-2">
                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider px-4">Account</p>
            </div>

            <x-nav-link :href="route('profile.edit')" :active="request()->routeIs('profile.edit')">
                <span class="mr-3">👤</span>
                {{ __('Profile') }}
            </x-nav-link>

            <!-- Authentication -->
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="w-full text-left flex items-center px-4 py-3 text-gray-400 hover:text-gray-200 hover:bg-gray-800 border-r-4 border-transparent transition duration-150 ease-in-out"
                    onclick="event.preventDefault(); this.closest('form').submit();">
                    <span class="mr-3">🚪</span>
                    {{ __('Log Out') }}
                </button>
            </form>
        </div>
    </div>

    <div class="absolute bottom-0 w-full p-4 border-t border-gray-800 bg-gray-950">
        <div class="flex items-center gap-3">
            <div
                class="h-10 w-10 rounded-full bg-blue-600 flex items-center justify-center font-bold text-white shadow-lg">
                {{ substr(Auth::user()->name, 0, 1) }}
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-sm font-bold text-white truncate">{{ Auth::user()->name }}</p>
                <p class="text-xs text-gray-500 truncate">{{ Auth::user()->email }}</p>
            </div>
            <!-- <x-notifications-bell /> -->
        </div>
    </div>
</nav>