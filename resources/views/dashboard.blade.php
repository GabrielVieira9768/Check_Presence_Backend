<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            {{ __('Minhas Disciplinas') }}
        </h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @foreach (auth()->user()->subjectsTaught as $subject)
                <div class="bg-white border border-gray-200 shadow-sm p-6 hover:shadow-md transition rounded">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <h3 class="text-xl font-bold text-gray-800">{{ $subject->name }}</h3>
                            <span class="text-sm text-gray-500">Código: {{ $subject->code }}</span>
                        </div>
                    </div>

                    <p class="text-gray-600 text-sm mb-4">
                        {{ $subject->description ?? 'Sem descrição.' }}
                    </p>

                    <a href="{{ route('subjects.classrooms', $subject->id) }}">
                        <x-primary-button class="w-full justify-center px-2">
                            Gerenciar Aulas
                        </x-primary-button>
                    </a>
                </div>
            @endforeach
        </div>

        @if (auth()->user()->subjectsTaught->isEmpty())
            <div class="text-center text-gray-500 mt-12">
                Nenhuma disciplina atribuída a você ainda.
            </div>
        @endif
    </div>
</x-app-layout>
