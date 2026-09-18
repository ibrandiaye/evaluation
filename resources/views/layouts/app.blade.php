<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Plateforme d'Évaluation</title>
    <!-- Tailwind CSS for quick styling -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-800 font-sans min-h-screen">
    
    <header class="bg-blue-600 text-white shadow-md">
        <div class="container mx-auto px-4 py-4 flex justify-between items-center">
            <h1 class="text-2xl font-bold"><a href="{{ route('evaluation.index') }}">Évaluation Apprenant</a></h1>
            @auth
            <div class="flex items-center">
                <span class="text-white mr-4">Admin</span>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-bold py-1 px-3 rounded text-sm">
                        Déconnexion
                    </button>
                </form>
            </div>
            @endauth
        </div>
    </header>

    <main class="container mx-auto px-4 py-8">
        @yield('content')
    </main>

    <footer class="text-center py-6 text-gray-500 text-sm">
        &copy; {{ date('Y') }} - Plateforme d'Évaluation
    </footer>
</body>
</html>
