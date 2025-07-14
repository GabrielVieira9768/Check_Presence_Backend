<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            QR Code da Aula {{ $classroom->code }}
        </h2>
    </x-slot>

    <div class="py-12 max-w-3xl mx-auto flex flex-col items-center text-center">
        {!! $qrCodeSvg !!}
        <p class="mt-4 text-lg font-semibold">Senha da aula: {{ $senha }}</p>

        <a href="{{ route('subjects.classrooms', $classroom->subject_id) }}" class="mt-6">
            <x-primary-button>
                Voltar para Aulas
            </x-primary-button>
        </a>
    </div>
</x-app-layout>