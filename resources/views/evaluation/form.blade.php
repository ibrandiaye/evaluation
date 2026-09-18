@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <h2 class="text-xl font-semibold mb-2">Candidat : {{ session('participant_name') }}</h2>
        <p class="text-gray-600">Veuillez répondre à toutes les questions ci-dessous.</p>
    </div>

    <form action="{{ route('evaluation.submit') }}" method="POST">
        @csrf
        
        @foreach($questions as $index => $question)
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">
                <span class="font-bold mr-2">{{ $index + 1 }}.</span> {{ $question->content }}
            </h3>
            
            <div class="space-y-3">
                @foreach($question->options as $option)
                <label class="flex items-start cursor-pointer hover:bg-gray-50 p-2 rounded">
                    <div class="flex items-center h-5">
                        <input type="radio" name="question_{{ $question->id }}" value="{{ $option->id }}" required class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                    </div>
                    <div class="ml-3 text-sm">
                        <span class="font-medium text-gray-700 block">
                            @if($question->type === 'multiple_choice')
                                {{ $option->letter }})
                            @endif
                            {{ $option->content }}
                        </span>
                    </div>
                </label>
                @endforeach
            </div>
        </div>
        @endforeach

        <div class="flex justify-end mb-8">
            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-8 rounded-lg shadow focus:outline-none focus:ring-2 focus:ring-green-500">
                Soumettre mes réponses
            </button>
        </div>
    </form>
</div>
@endsection
