<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Agendamed – Agende suas Consultas</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-white text-gray-800 min-h-screen flex flex-col justify-between">

    {{-- Top Navbar --}}
    <header class="w-full border-b border-gray-200 bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center">
            <h1 class="text-lg font-semibold text-blue-700">Agendamed</h1>
            
            @if (Route::has('login'))
                <nav class="flex items-center gap-4">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="text-sm text-gray-800 hover:underline">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="text-sm text-blue-600 hover:underline">
                            Entrar
                        </a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="text-sm text-blue-600 hover:underline">
                                Cadastre-se
                            </a>
                        @endif
                    @endauth
                </nav>
            @endif
        </div>
    </header>

    {{-- Main Content --}}
    <main class="flex-grow bg-gray-50">
        <div class="max-w-7xl mx-auto px-6 py-16 grid grid-cols-1 md:grid-cols-2 items-center gap-12">
            <div>
                <h2 class="text-4xl font-bold text-blue-800 mb-6">
                    Agende suas consultas com facilidade e segurança
                </h2>
                <p class="text-gray-700 text-lg mb-6 leading-relaxed">
                    Com nosso sistema CRM Médico, você como paciente pode visualizar especialidades, médicos disponíveis e horários de atendimento. Tudo isso com autonomia, praticidade e em tempo real.
                </p>

                <ul class="list-disc list-inside text-gray-600 text-base mb-6 space-y-1">
                    <li>Acesso rápido ao histórico de agendamentos</li>
                    <li>Confirmação automática via sistema</li>
                    <li>Visualização de horários disponíveis por médico</li>
                </ul>

                @guest
                    <a href="{{ route('register') }}" class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-medium px-6 py-3 rounded shadow transition">
                        Criar minha conta
                    </a>
                @endguest
            </div>

            <div class="text-center">
                <img src="https://cdn-icons-png.flaticon.com/512/4140/4140037.png" alt="Paciente agendando consulta"
                     class="mx-auto w-3/4 max-w-sm">
            </div>
        </div>
    </main>

    {{-- Footer --}}
    <footer class="bg-white border-t border-gray-200 text-sm text-gray-600">
        <div class="max-w-7xl mx-auto px-4 py-6 flex flex-col sm:flex-row justify-between items-center">
            <p>&copy; {{ date('Y') }} CRM Médico. Todos os direitos reservados.</p>
            <div class="flex space-x-4 mt-2 sm:mt-0">
                <a href="#" class="hover:text-blue-600 transition">Política de Privacidade</a>
                <a href="#" class="hover:text-blue-600 transition">Termos de Uso</a>
                <a href="#" class="hover:text-blue-600 transition">Contato</a>
            </div>
        </div>
    </footer>

</body>
</html>
