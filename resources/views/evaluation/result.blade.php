@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="bg-white rounded-lg shadow-md p-8 text-center mb-8">
        <h2 class="text-3xl font-bold text-gray-800 mb-4">Évaluation terminée !</h2>
        <p class="text-lg text-gray-600 mb-6">Merci <span class="font-semibold">{{ $evaluation->participant_name }}</span>.</p>
        
        <div class="text-green-600 mb-6 text-xl">
            Vos réponses ont bien été enregistrées.
        </div>
        
        <p class="text-gray-500 mb-8">Les résultats seront communiqués par l'administrateur.</p>

        <div class="mt-4">
            <a href="{{ route('evaluation.index') }}" class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded focus:outline-none focus:shadow-outline">
                Retour à l'accueil
            </a>
        </div>
    </div>
</div>
@endsection
