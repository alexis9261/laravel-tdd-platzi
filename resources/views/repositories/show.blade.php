<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Repositories') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-8">
                <div class="">
                    <strong>Id: </strong> {{ $repository->url }}
                </div>
                <div>
                    <strong>Descripcion: </strong>
                    {{ $repository->description }}
                </div>
                <div>
                    <strong>Url: </strong>
                    {{ $repository->url }}
                </div>
                <div>
                    <strong>Author: </strong>
                    {{ $repository->user->name }}
                </div>
                <div class="mt-4">
                    <a class="bg-green-600 text-white font-bold py-1 px-6 rounded-md shadow-md" href="{{ route('repositories.index') }}">Volver</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
