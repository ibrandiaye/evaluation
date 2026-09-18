<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OIDP Afrique - Évaluation Apprenant</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        oidp: {
                            orange: '#E8751A',
                            'orange-dark': '#C85F0E',
                            blue: '#3AAFE0',
                            'blue-dark': '#2E8FBA',
                            dark: '#333333',
                        }
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-50 text-gray-800 font-sans min-h-screen flex flex-col">

    <header class="bg-white shadow-md border-b-4 border-oidp-orange">
        <div class="container mx-auto px-4 py-3 flex justify-between items-center">
            <a href="{{ route('evaluation.index') }}" class="flex items-center space-x-3">
                <img src="{{ asset('logo-oidp.jpg') }}" alt="OIDP Afrique" class="h-12">
                <span class="text-oidp-dark font-bold text-lg hidden sm:inline">Évaluation Apprenant</span>
            </a>
            @auth
            <div class="flex items-center space-x-3">
                <a href="{{ route('admin.index') }}" class="text-oidp-orange hover:text-oidp-orange-dark font-medium text-sm">Administration</a>
                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-bold py-1.5 px-3 rounded text-sm transition">
                        Déconnexion
                    </button>
                </form>
            </div>
            @endauth
        </div>
    </header>

    <main class="flex-1 container mx-auto px-4 py-8">
        @yield('content')
    </main>

    <footer class="bg-oidp-dark text-gray-300 text-center py-4 text-sm">
        &copy; {{ date('Y') }} OIDP Afrique / IOPD Africa — Plateforme d'Évaluation
    </footer>
</body>
</html>
