<x-guest-layout>
    <div class="text-center mb-10">
        <h2 class="text-2xl font-black text-white tracking-tight">Accès Sécurisé</h2>
        <p class="text-gray-400 text-sm mt-2">Connectez-vous à votre espace personnel</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-6" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" class="text-gray-300 ml-1 mb-2" />
            <x-text-input id="email" class="block w-full bg-gray-800/50 border-gray-700 text-white focus:border-blue-500 focus:ring-blue-500/20 py-3" 
                          type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="votre@email.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <div class="flex justify-between items-center mb-2 ml-1">
                <x-input-label for="password" :value="__('Mot de passe')" class="text-gray-300" />
                @if (Route::has('password.request'))
                    <a class="text-xs text-blue-400 hover:text-blue-300 transition" href="{{ route('password.request') }}">
                        {{ __('Oublié ?') }}
                    </a>
                @endif
            </div>

            <x-text-input id="password" class="block w-full bg-gray-800/50 border-gray-700 text-white focus:border-blue-500 focus:ring-blue-500/20 py-3"
                            type="password"
                            name="password"
                            required autocomplete="current-password"
                            placeholder="••••••••" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center">
            <input id="remember_me" type="checkbox" class="rounded bg-gray-800 border-gray-700 text-blue-600 shadow-sm focus:ring-blue-500/20" name="remember">
            <label for="remember_me" class="ml-2 text-sm text-gray-400">
                {{ __('Se souvenir de moi') }}
            </label>
        </div>

        <div>
            <x-primary-button class="w-full justify-center py-4 text-sm font-bold uppercase tracking-widest bg-blue-600 hover:bg-blue-500 shadow-lg shadow-blue-500/20 transition-all duration-300">
                {{ __('Connexion') }}
            </x-primary-button>
        </div>

        <div class="pt-4 text-center border-t border-gray-800/50">
            @if (Route::has('register'))
                <span class="text-sm text-gray-500">Pas encore de compte ?</span>
                <a class="text-sm font-bold text-blue-400 hover:text-blue-300 ml-1 transition" href="{{ route('register') }}">
                    {{ __('S\'inscrire') }}
                </a>
            @endif
        </div>

        <!-- Security Footer -->
        <div class="mt-8 flex items-center justify-center gap-2 py-3 px-4 bg-gray-950/50 rounded-xl border border-gray-800/50">
            <span class="text-[10px] text-gray-500 font-black uppercase tracking-[0.2em]">
                🔒 Session Chiffrée
            </span>
        </div>
    </form>
</x-guest-layout>