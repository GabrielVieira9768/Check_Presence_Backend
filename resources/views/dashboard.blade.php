<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Minhas Disciplinas') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @foreach (auth()->user()->subjectsTaught as $subject)
                <div class="bg-white shadow-sm sm:rounded-lg p-6 mb-4">
                    <h3 class="text-lg font-bold">{{ $subject->name }} ({{ $subject->code }})</h3>
                    <p class="text-sm text-gray-600 mb-2">{{ $subject->description }}</p>
                    <a href="{{ route('subjects.classrooms', $subject->id) }}">
                        <x-primary-button>
                            Gerenciar
                        </x-primary-button>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
