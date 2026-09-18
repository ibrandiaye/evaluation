@extends('layouts.app')

@section('content')
<div class="max-w-lg mx-auto mt-8">
    <div class="bg-white rounded-xl shadow-lg p-8 text-center border-t-4 border-oidp-orange">
        <div class="mb-6">
            <div class="w-20 h-20 mx-auto bg-green-100 rounded-full flex items-center justify-center mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                </svg>
            </div>
            <h2 class="text-2xl font-bold text-oidp-dark mb-2">Évaluation terminée !</h2>
            <p class="text-lg text-gray-600">Merci <span class="font-bold text-oidp-orange">{{ $evaluation->participant_name }}</span>.</p>
        </div>

        <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-6">
            <p class="text-green-700 font-medium">✓ Vos réponses ont bien été enregistrées.</p>
        </div>

        <p class="text-gray-500 mb-8 text-sm">Les résultats seront communiqués par l'administrateur.</p>

        <a href="{{ route('evaluation.index') }}" class="inline-block bg-oidp-orange hover:bg-oidp-orange-dark text-white font-bold py-3 px-6 rounded-lg transition shadow-md">
            Retour à l'accueil
        </a>
    </div>
</div>
@endsection
