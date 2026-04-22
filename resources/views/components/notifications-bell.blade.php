<div x-data="{ open: false }" class="relative">
    <button @click="open = !open" class="text-gray-500 hover:text-gray-800 transition duration-150 ease-in-out relative flex items-center p-2 rounded-full hover:bg-gray-100" title="{{ __('Notifications') }}">
        <i class="bi bi-bell text-xl"></i>
        @if(auth()->user()->unreadNotifications->count() > 0)
            <span class="absolute top-1 right-1 bg-red-500 text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full border-2 border-white">
                {{ auth()->user()->unreadNotifications->count() }}
            </span>
        @endif
    </button>

    <div x-show="open" 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         @click.away="open = false" 
         x-cloak
         class="absolute right-0 mt-2 w-72 bg-gray-900 border border-gray-800 rounded-lg shadow-xl py-2 z-[100] overflow-hidden">
        
        <div class="px-4 py-2 border-b border-gray-800 flex justify-between items-center bg-gray-950/50">
            <span class="text-xs font-bold text-gray-400 uppercase tracking-widest">{{ __('Alertes Mission') }}</span>
            <span class="text-[10px] bg-red-500/10 text-red-400 px-2 py-0.5 rounded border border-red-500/20">LIVE</span>
        </div>

        <div class="max-h-64 overflow-y-auto">
            @forelse(auth()->user()->unreadNotifications->take(5) as $notification)
                <div class="px-4 py-3 hover:bg-gray-800 border-b border-gray-800 last:border-0 transition duration-150">
                    <p class="text-xs text-gray-300 leading-snug">
                        {{ $notification->data['message'] ?? 'Nouvelle mise à jour de mission.' }}
                    </p>
                    <div class="flex justify-between items-center mt-2">
                        <a href="{{ $notification->data['url'] ?? '#' }}" class="text-[10px] text-blue-400 hover:text-blue-300 font-bold uppercase tracking-tighter">
                            {{ __('Ouvrir le signal') }} &rarr;
                        </a>
                        <form action="{{ route('notifications.read', $notification->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="text-[9px] text-gray-500 hover:text-red-400 uppercase font-black uppercase tracking-widest">
                                {{ __('Acquitter') }}
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="px-4 py-8 text-center">
                    <p class="text-xs text-gray-500 italic">{{ __('Aucun nouveau signal.') }}</p>
                </div>
            @endforelse
        </div>

        @if(auth()->user()->unreadNotifications->count() > 0)
            <div class="px-4 py-2 bg-gray-950/50 text-center">
                <a href="{{ route('dashboard') }}" class="text-[10px] text-gray-400 hover:text-white uppercase font-bold tracking-widest">
                    {{ __('Archives Complètes') }}
                </a>
            </div>
        @endif
    </div>
</div>
