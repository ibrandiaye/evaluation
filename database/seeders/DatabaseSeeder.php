<?php

namespace Database\Seeders;

use App\Models\Option;
use App\Models\Question;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 0. Create the Admin user
        User::create([
            'name' => 'Administrateur',
            'email' => 'admin@enda.org',
            'password' => Hash::make('password123'),
        ]);

        // 1. Insert 50 Vrai/Faux questions
        $json = file_get_contents(database_path('vrai_faux.json'));
        if ($json) {
            $questions = json_decode($json, true);
            foreach ($questions as $q) {
                $question = Question::create([
                    'content' => $q['question'],
                    'type' => 'boolean'
                ]);
                Option::create([
                    'question_id' => $question->id, 
                    'content' => 'Vrai', 
                    'is_correct' => ($q['answer'] === 'VRAI'), 
                    'letter' => 'V'
                ]);
                Option::create([
                    'question_id' => $question->id, 
                    'content' => 'Faux', 
                    'is_correct' => ($q['answer'] === 'FAUX'), 
                    'letter' => 'F'
                ]);
            }
        }

        // 2. Insert 50 QCM questions
        $qcmJson = file_get_contents(database_path('qcm.json'));
        if ($qcmJson) {
            $qcmQuestions = json_decode($qcmJson, true);
            $letters = ['A', 'B', 'C', 'D', 'E', 'F'];
            foreach ($qcmQuestions as $q) {
                $question = Question::create([
                    'content' => $q['question'],
                    'type' => 'multiple_choice'
                ]);
                
                foreach ($q['options'] as $index => $optText) {
                    $letter = $letters[$index] ?? 'A';
                    Option::create([
                        'question_id' => $question->id,
                        'content' => $optText,
                        'is_correct' => ($letter === $q['answer']),
                        'letter' => $letter
                    ]);
                }
            }
        }
    }
}
