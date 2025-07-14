<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $subject->name }} – Aulas
        </h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">

        @if (session('success'))
            <div class="mb-6 p-4 bg-green-100 text-green-700 rounded">
                {{ session('success') }}
            </div>
        @endif

        {{-- Form para criar nova aula --}}
        <div class="bg-white p-6 rounded shadow mb-4">
            <h3 class="text-lg font-bold mb-4">Adicionar nova aula</h3>
            <form action="{{ route('classrooms.store') }}" method="POST">
                @csrf
                <input type="hidden" name="subject_id" value="{{ $subject->id }}" />

                <div class="mb-4">
                    <label for="code" class="block font-medium text-gray-700">Código da Aula</label>
                    <input type="text" name="code" id="code" class="mt-1 block w-full border rounded px-3 py-2" required />
                </div>

                <div class="mb-4">
                    <label for="date" class="block font-medium text-gray-700">Data</label>
                    <input type="date" name="date" id="date" class="mt-1 block w-full border rounded px-3 py-2" required />
                </div>

                <div class="mb-4">
                    <label for="start_time" class="block font-medium text-gray-700">Horário de Início</label>
                    <input type="time" name="start_time" id="start_time" class="mt-1 block w-full border rounded px-3 py-2" required />
                </div>

                <div class="mb-4">
                    <label for="end_time" class="block font-medium text-gray-700">Horário de Fim</label>
                    <input type="time" name="end_time" id="end_time" class="mt-1 block w-full border rounded px-3 py-2" required />
                </div>

                <div class="mb-4">
                    <label for="location" class="block font-medium text-gray-700">Local (opcional)</label>
                    <input type="text" name="location" id="location" class="mt-1 block w-full border rounded px-3 py-2" />
                </div>

                <x-primary-button type="submit">
                    Criar Aula
                </x-primary-button>
            </form>
        </div>

        {{-- Listagem das aulas --}}
        @php
            $students = $subject->students()->orderBy('name')->get();
        @endphp

        @foreach ($subject->classrooms as $classroom)
            <div class="bg-white p-6 shadow-sm rounded-lg mb-4">
                <div class="flex justify-between items-center">
                    <h3 class="text-md font-bold">
                        Aula: {{ $classroom->code }} — {{ $classroom->date->format('d/m/Y') }}
                        ({{ \Carbon\Carbon::parse($classroom->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($classroom->end_time)->format('H:i') }})
                    </h3>

                    {{-- Botão Gerar QR Code --}}
                    <a href="{{ route('classrooms.qrcode', $classroom->id) }}">
                        <x-primary-button>
                            Gerar QR Code
                        </x-primary-button>
                    </a>
                </div>

                <p class="text-sm text-gray-600">Local: {{ $classroom->location ?? 'Não informado' }}</p>

                <h4 class="font-semibold mt-4">Frequência dos Alunos:</h4>
                <ul class="list-disc ml-6">
                    @foreach ($students as $student)
                        @php
                            $presence = $classroom->presences->firstWhere('user_id', $student->id);
                        @endphp
                        <li>
                            {{ $student->name }} —
                            @if ($presence)
                                <span class="{{ $presence->status ? 'text-green-600' : 'text-red-600' }}">
                                    {{ $presence->status ? 'Presente' : 'Ausente' }}
                                </span>
                                @if ($presence->status)
                                    <span class="text-gray-500 text-sm ml-2">
                                        (Registrado às {{ \Carbon\Carbon::parse($presence->regisred_at)->format('H:i:s') }})
                                    </span>
                                @else
                                    <span class="text-gray-500 text-sm ml-2">
                                        Não registrado
                                    </span>
                                @endif
                            @else
                                <span class="text-gray-500 italic">Não registrado</span>
                            @endif
                        </li>
                    @endforeach
                </ul>
            </div>
        @endforeach

        @if ($subject->classrooms->isEmpty())
            <div class="bg-white p-6 rounded shadow text-center">
                <p class="text-gray-500">Nenhuma aula registrada para este assunto.</p>
            </div>
        @endif

    </div>
</x-app-layout>
