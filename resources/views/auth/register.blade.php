<x-guest-layout>
    <div class="text-center mb-10">
        <h2 class="text-2xl font-black text-white tracking-tight">Création de Compte</h2>
        <p class="text-gray-400 text-sm mt-2">Rejoignez-nous en quelques secondes</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-6">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Nom complet')" class="text-gray-300 ml-1 mb-2" />
            <x-text-input id="name" class="block w-full bg-gray-800/50 border-gray-700 text-white focus:border-blue-500 focus:ring-blue-500/20 py-3" 
                          type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="John Doe" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Adresse Email')" class="text-gray-300 ml-1 mb-2" />
            <x-text-input id="email" class="block w-full bg-gray-800/50 border-gray-700 text-white focus:border-blue-500 focus:ring-blue-500/20 py-3" 
                          type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="john@example.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Mot de passe')" class="text-gray-300 ml-1 mb-2" />
            <x-text-input id="password" class="block w-full bg-gray-800/50 border-gray-700 text-white focus:border-blue-500 focus:ring-blue-500/20 py-3"
                            type="password"
                            name="password"
                            required autocomplete="new-password"
                            placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div>
            <x-input-label for="password_confirmation" :value="__('Confirmer')" class="text-gray-300 ml-1 mb-2" />
            <x-text-input id="password_confirmation" class="block w-full bg-gray-800/50 border-gray-700 text-white focus:border-blue-500 focus:ring-blue-500/20 py-3"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password"
                            placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div>
            <x-primary-button class="w-full justify-center py-4 text-sm font-bold uppercase tracking-widest bg-blue-600 hover:bg-blue-500 shadow-lg shadow-blue-500/20 transition-all duration-300">
                {{ __('S\'inscrire') }}
            </x-primary-button>
        </div>

        <div class="pt-4 text-center border-t border-gray-800/50">
            <span class="text-sm text-gray-500">Déjà un compte ?</span>
            <a class="text-sm font-bold text-blue-400 hover:text-blue-300 ml-1 transition" href="{{ route('login') }}">
                {{ __('Se connecter') }}
            </a>
        </div>
    </form>
</x-guest-layout>
