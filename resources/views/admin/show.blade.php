@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-6 flex justify-between items-center">
        <a href="{{ route('admin.index') }}" class="text-blue-600 hover:underline">&larr; Retour aux évaluations</a>
    </div>

    <div class="bg-white rounded-lg shadow-md p-8 mb-8">
        <h2 class="text-2xl font-bold text-gray-800 mb-2">Détails de l'évaluation</h2>
        <p class="text-lg text-gray-600 mb-6">Candidat : <span class="font-semibold">{{ $evaluation->participant_name }}</span></p>
        
        @php
            $percentage = $evaluation->total_questions > 0 ? ($evaluation->score / $evaluation->total_questions) * 100 : 0;
            $color = $percentage >= 50 ? 'text-green-600' : 'text-red-600';
        @endphp

        <div class="text-4xl font-black {{ $color }} mb-2">
            {{ $evaluation->score }} / {{ $evaluation->total_questions }}
        </div>
        <p class="text-gray-500 font-medium">Soit {{ number_format($percentage, 0) }}% de réussite</p>
    </div>

    <h3 class="text-xl font-bold mb-4">Réponses du candidat</h3>
    
    @foreach($evaluation->answers as $index => $answer)
    <div class="bg-white rounded-lg shadow-md p-6 mb-4 border-l-4 {{ $answer->is_correct ? 'border-green-500' : 'border-red-500' }}">
        <h4 class="text-lg font-medium text-gray-900 mb-3">
            <span class="font-bold mr-1">{{ $index + 1 }}.</span> {{ $answer->question->content }}
        </h4>
        
        <div class="pl-4">
            <p class="mb-2">
                <span class="text-gray-600 text-sm">Réponse du candidat :</span><br>
                <span class="font-medium {{ $answer->is_correct ? 'text-green-600' : 'text-red-600' }}">
                    {{ $answer->option->content }} 
                    @if($answer->is_correct)
                        (Correct)
                    @else
                        (Incorrect)
                    @endif
                </span>
            </p>
            
            @if(!$answer->is_correct)
                @php
                    $correctOption = $answer->question->options->where('is_correct', true)->first();
                @endphp
                <p>
                    <span class="text-gray-600 text-sm">Bonne réponse attendue :</span><br>
                    <span class="font-medium text-green-600">{{ $correctOption ? $correctOption->content : 'Non définie' }}</span>
                </p>
            @endif
        </div>
    </div>
    @endforeach
</div>
@endsection
