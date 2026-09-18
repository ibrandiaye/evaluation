@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Gestion des Questions</h2>
        <a href="{{ route('admin.index') }}" class="text-blue-600 hover:underline">Voir les Statistiques Candidats</a>
    </div>

    <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 mb-6">
        <p><strong>Info:</strong> {{ $questions->count() }} questions actuellement enregistrées en base (VRAI/FAUX et QCM importées).</p>
        <p class="text-sm mt-1">L'ajout de nouvelles questions pourra être développé dans un formulaire dédié ici.</p>
    </div>

    <div class="space-y-4">
        @foreach($questions as $index => $question)
        <div class="bg-white rounded p-4 shadow">
            <h3 class="font-bold text-gray-800 mb-2">{{ $index + 1 }}. {{ $question->content }}</h3>
            <ul class="list-disc list-inside text-sm text-gray-600">
                @foreach($question->options as $option)
                    <li class="{{ $option->is_correct ? 'text-green-600 font-bold' : '' }}">
                        {{ $option->content }} 
                        @if($option->is_correct) (VRAI) @endif
                    </li>
                @endforeach
            </ul>
        </div>
        @endforeach
    </div>
</div>
@endsection
