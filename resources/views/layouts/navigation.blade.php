<nav x-data="{ open: false }" class="bg-[#0f172a] fixed inset-y-0 left-0 w-64 flex flex-col z-50 text-slate-300 shadow-xl">

    <!-- Header Block (Matches Dossier Prime reference) -->
    <div class="px-8 py-10">
        <h1 class="text-white font-extrabold text-xl tracking-tight">App Mission</h1>
        <p class="text-slate-500 text-xs mt-1 font-medium">Strategic Ops</p>
    </div>

    <!-- Navigation Links -->
    <div class="flex-1 flex flex-col gap-2 mt-4">
        <!-- Dashboard Link -->
        <a href="{{ route('dashboard') }}" 
           class="flex items-center gap-4 px-8 py-3 {{ request()->routeIs('dashboard') ? 'bg-[#1e293b] border-l-[3px] border-indigo-500 text-white font-semibold' : 'border-l-[3px] border-transparent hover:bg-slate-800/40 hover:text-white transition-colors' }}">
            <svg class="w-[18px] h-[18px] {{ request()->routeIs('dashboard') ? 'text-white' : 'opacity-60' }}" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z" />
            </svg>
            <span class="text-[0.95rem] tracking-wide">{{ __('Mission Control') }}</span>
        </a>

        <!-- Missions Link -->
        <a href="{{ route('missions.index') }}" 
           class="flex items-center gap-4 px-8 py-3 {{ request()->routeIs('missions.*') ? 'bg-[#1e293b] border-l-[3px] border-indigo-500 text-white font-semibold' : 'border-l-[3px] border-transparent hover:bg-slate-800/40 hover:text-white transition-colors' }}">
            <svg class="w-[18px] h-[18px] {{ request()->routeIs('missions.*') ? 'text-white' : 'opacity-60' }}" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" d="M15.666 3.888A2.25 2.25 0 0013.5 2.25h-3c-1.03 0-1.9.693-2.166 1.638m7.332 0c.055.194.084.4.084.612v0a.75.75 0 01-.75.75H9a.75.75 0 01-.75-.75v0c0-.212.03-.418.084-.612m7.332 0c.646.049 1.288.11 1.927.184 1.1.128 1.907 1.077 1.907 2.185V19.5a2.25 2.25 0 01-2.25 2.25H6.75A2.25 2.25 0 014.5 19.5V6.257c0-1.108.806-2.057 1.907-2.185a48.208 48.208 0 011.927-.184" />
            </svg>
            <span class="text-[0.95rem] tracking-wide">{{ __('Asset Fleet') }}</span>
        </a>

        <!-- Profile Link -->
        <a href="{{ route('profile.edit') }}" 
           class="flex items-center gap-4 px-8 py-3 {{ request()->routeIs('profile.edit') ? 'bg-[#1e293b] border-l-[3px] border-indigo-500 text-white font-semibold' : 'border-l-[3px] border-transparent hover:bg-slate-800/40 hover:text-white transition-colors' }}">
            <svg class="w-[18px] h-[18px] {{ request()->routeIs('profile.edit') ? 'text-white' : 'opacity-60' }}" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
            </svg>
            <span class="text-[0.95rem] tracking-wide">{{ __('Settings') }}</span>
        </a>

        <!-- Logout Link -->
        <form method="POST" action="{{ route('logout') }}" class="w-full mt-2">
            @csrf
            <button type="submit" class="w-full flex items-center gap-4 px-8 py-3 border-l-[3px] border-transparent hover:bg-slate-800/40 hover:text-white transition-colors text-left">
                <svg class="w-[18px] h-[18px] opacity-60 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
                </svg>
                <span class="text-[0.95rem] tracking-wide">{{ __('Log Out') }}</span>
            </button>
        </form>
    </div>


</nav>