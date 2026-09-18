@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto mt-12">
    <div class="bg-white rounded-xl shadow-lg overflow-hidden border-t-4 border-oidp-orange">
        <div class="px-8 pt-8 pb-4 text-center">
            <div class="w-16 h-16 mx-auto bg-oidp-orange bg-opacity-10 rounded-full flex items-center justify-center mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-oidp-orange" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                </svg>
            </div>
            <h2 class="text-2xl font-bold text-oidp-dark mb-2">Espace Administrateur</h2>
            <p class="text-gray-500 text-sm mb-6">Connexion requise pour accéder aux résultats.</p>
        </div>

        <div class="px-8 pb-8">
            <form action="{{ route('login') }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label for="email" class="block text-oidp-dark font-semibold mb-2">Adresse Email</label>
                    <input type="email" name="email" id="email"
                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-oidp-orange transition"
                        value="{{ old('email') }}" required autofocus placeholder="admin@enda.org">
                    @error('email')
                        <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="password" class="block text-oidp-dark font-semibold mb-2">Mot de passe</label>
                    <input type="password" name="password" id="password"
                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-oidp-orange transition"
                        required placeholder="••••••••">
                </div>

                <button type="submit" class="w-full bg-oidp-orange hover:bg-oidp-orange-dark text-white font-bold py-3 px-4 rounded-lg transition shadow-md">
                    Se connecter
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
