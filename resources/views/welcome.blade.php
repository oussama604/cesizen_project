<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>CESIZen</title>
        <link rel="icon" type="image/svg+xml" href="{{ asset('cesizen-mark.svg') }}">

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-slate-50 text-slate-900">
        <header class="max-w-7xl mx-auto px-6 py-6 flex items-center justify-between">
            <a href="{{ route('home') }}" class="shrink-0">
                <x-application-logo class="block h-16 w-auto sm:h-20" />
            </a>
            <nav class="flex items-center gap-3 text-sm">
                <a href="{{ route('information.index') }}" class="text-slate-700 hover:text-cesi-green-700">Informations</a>
                @auth
                    <a href="{{ route('dashboard') }}" class="inline-flex items-center px-4 py-2 rounded-md bg-cesi-green-500 text-white font-medium hover:bg-cesi-green-600">Tableau de bord</a>
                @else
                    <a href="{{ route('login') }}" class="text-slate-700 hover:text-cesi-green-700">Connexion</a>
                    <a href="{{ route('register') }}" class="inline-flex items-center px-4 py-2 rounded-md bg-cesi-green-500 text-white font-medium hover:bg-cesi-green-600">Inscription</a>
                @endauth
            </nav>
        </header>

        <main class="max-w-7xl mx-auto px-6 pb-16">
            <section class="rounded-2xl bg-gradient-to-br from-cesi-green-600 via-cesi-green-500 to-cesi-yellow-400 text-white p-8 md:p-12 shadow-xl">
                <p class="text-xs uppercase tracking-[0.2em] text-cesi-yellow-100">Application de prevention</p>
                <h1 class="mt-3 text-3xl md:text-5xl font-bold leading-tight">Prenez soin de votre sante mentale avec CESIZen.</h1>
                <p class="mt-4 max-w-2xl text-white/90">Plateforme Laravel pour informer, diagnostiquer le stress (echelle Holmes-Rahe) et suivre l'evolution de vos resultats dans le temps.</p>
                <div class="mt-8 flex flex-wrap gap-3">
                    <a href="{{ route('diagnostics.create') }}" class="inline-flex items-center px-5 py-3 rounded-md bg-white text-cesi-green-700 font-semibold hover:bg-cesi-yellow-50">Demarrer un diagnostic</a>
                    <a href="{{ route('information.index') }}" class="inline-flex items-center px-5 py-3 rounded-md border border-cesi-yellow-200 text-white font-semibold hover:bg-white/10">Consulter les contenus</a>
                </div>
            </section>

            <section class="mt-8 grid gap-5 md:grid-cols-3">
                <article class="bg-white border border-slate-200 rounded-xl p-5 shadow-sm">
                    <h2 class="font-semibold text-lg">Gestion des utilisateurs</h2>
                    <p class="mt-2 text-sm text-slate-600">Inscription, connexion, role utilisateur/admin, consentement RGPD, suivi de derniere connexion et activation/desactivation.</p>
                </article>
                <article class="bg-white border border-slate-200 rounded-xl p-5 shadow-sm">
                    <h2 class="font-semibold text-lg">Module Informations</h2>
                    <p class="mt-2 text-sm text-slate-600">Publication de contenus sur le stress, la sante mentale et la prevention via un espace d'administration dedie.</p>
                </article>
                <article class="bg-white border border-slate-200 rounded-xl p-5 shadow-sm">
                    <h2 class="font-semibold text-lg">Diagnostic de stress</h2>
                    <p class="mt-2 text-sm text-slate-600">Calcul automatique du score Holmes-Rahe avec classification faible, modere ou eleve et historisation des resultats.</p>
                </article>
            </section>
        </main>
    </body>
</html>
