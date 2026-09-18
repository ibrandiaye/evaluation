@extends('layouts.app')

@section('content')
<div class="max-w-lg mx-auto mt-8">
    <div class="bg-white rounded-xl shadow-lg overflow-hidden border-t-4 border-oidp-orange">
        <div class="px-8 pt-8 pb-2 text-center">
            <img src="{{ asset('logo-oidp.jpg') }}" alt="OIDP Afrique" class="h-20 mx-auto mb-4">
            <h2 class="text-2xl font-bold text-oidp-dark mb-2">Évaluation des Apprenants</h2>
            <p class="text-gray-500 text-sm mb-6">
                Testez votre compréhension sur le Budget Participatif et la Facilitation.<br>
                <span class="font-medium text-oidp-orange">100 questions</span> — Vrai/Faux et QCM.
            </p>
        </div>

        <div class="px-8 pb-8">
            <form action="{{ route('evaluation.start') }}" method="POST">
                @csrf
                <div class="mb-5">
                    <label for="participant_name" class="block text-oidp-dark font-semibold mb-2">Prénom et Nom</label>
                    <input type="text" name="participant_name" id="participant_name" required
                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-oidp-orange transition"
                        placeholder="Ex: Jean Dupont">
                    @error('participant_name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="w-full bg-oidp-orange hover:bg-oidp-orange-dark text-white font-bold py-3 px-4 rounded-lg transition shadow-md hover:shadow-lg">
                    Commencer l'évaluation →
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
