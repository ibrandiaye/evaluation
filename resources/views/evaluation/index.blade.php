@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto bg-white rounded-lg shadow-md overflow-hidden">
    <div class="px-6 py-8">
        <h2 class="text-2xl font-bold text-center text-gray-700 mb-6">Bienvenue à l'évaluation</h2>
        
        <p class="text-gray-600 text-center mb-6">
            Veuillez entrer votre prénom et nom pour commencer le questionnaire.
        </p>

        <form action="{{ route('evaluation.start') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="participant_name" class="block text-gray-700 font-bold mb-2">Prénom et Nom :</label>
                <input type="text" name="participant_name" id="participant_name" required 
                    class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring focus:ring-blue-200" 
                    placeholder="Ex: Jean Dupont">
                @error('participant_name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                Commencer l'évaluation
            </button>
        </form>
    </div>
</div>
@endsection
