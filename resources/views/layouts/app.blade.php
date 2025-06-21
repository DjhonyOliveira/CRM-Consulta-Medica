<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Posto Saude</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 flex justify-between items-center">
                        <div>
                            {{ $header }}
                        </div>
                        <div>
                            <a href="{{ url()->previous() }}" class="text-sm bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold py-2 px-4 rounded">
                                ← Voltar
                            </a>
                        </div>
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
        @stack('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                window.buttonCrud();                    

                Livewire.on('openModal', () => {
                    setTimeout(()=>{
                        if (document.getElementById('draggableModal')){
                            window.Modal();
                            window.submitModal();
                        }
                    }, 100)
                });
            });
        </script>
        @livewireScripts

        <!-- Tratamento de erros e alertas -->
        <div id="toast-container" class="fixed bottom-4 right-4 z-50 space-y-2"></div>
        <x-exception-pop-up id="exception-popup" />
    </body>
</html>
