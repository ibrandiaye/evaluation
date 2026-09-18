const fs = require('fs');

let text = fs.readFileSync('qcm_raw.txt', 'utf8');
let lines = text.split(/[\r\n]+/).map(l => l.trim()).filter(l => l.length > 0);

let questions = [];
let currentQuestion = null;
let currentOptions = [];

for (let i = 0; i < lines.length; i++) {
    let line = lines[i];
    
    // Ignore titles that don't end in ? or : and are not options
    if (line.match(/^(Partie|Le rôle du facilitateur)/)) {
        continue;
    }

    // Is it an option?
    if (line.match(/^[A-D]\.\s/)) {
        line = line.replace(/^[A-D]\.\s*/, '');
        currentOptions.push(line);
    } else {
        // For the first part, options don't start with A., B., C., D.
        // How to know if it's a question or option?
        // Usually, questions end with `?` or `:`
        if (line.endsWith('?') || line.endsWith(':') || line.endsWith('l\'approche') || line.endsWith('unanimité où tout le monde est totalement d\'accord')) {
            // Wait, "l'approche" doesn't end in ? or :.
            // Let's just use a simple heuristic:
            // If currentQuestion is null, it's a question.
            if (currentQuestion && currentOptions.length > 0) {
                questions.push({ question: currentQuestion, options: currentOptions });
                currentOptions = [];
            }
            currentQuestion = line;
        } else {
            // It's an option (for the first part) or a continuation of a question
            if (currentQuestion) {
                // If it's a title mixed in, we might mistake it for an option, but titles usually don't appear in the first part.
                currentOptions.push(line);
            }
        }
    }
}
if (currentQuestion && currentOptions.length > 0) {
    questions.push({ question: currentQuestion, options: currentOptions });
}

console.log("Questions parsed:", questions.length);

const answersStr = "1 B 11 B 21 B 31 B 41 A 2 B 12 B 22 B 32 B 42 B 3 B 13 B 23 B 33 B 43 A 4 B 14 B 24 B 34 B 44 B 5 A 15 A 25 B 35 B 45 A 6 A 16 B 26 A 36 B 46 A 7 B 17 B 27 B 37 B 47 B 8 C 18 B 28 A 38 A 48 B 9 B 19 B 29 B 39 B 49 B 10 C 20 B 30 B 40 A 50 B";
const matches = [...answersStr.matchAll(/(\d+)\s+([A-D])/g)];
let answersMap = {};
matches.forEach(m => {
    answersMap[m[1]] = m[2];
});

let finalJson = [];
for (let i = 0; i < questions.length; i++) {
    if (i >= 50) break;
    finalJson.push({
        question: questions[i].question,
        options: questions[i].options,
        answer: answersMap[i+1]
    });
}

fs.writeFileSync('database/qcm.json', JSON.stringify(finalJson, null, 2));
console.log("Saved database/qcm.json");
