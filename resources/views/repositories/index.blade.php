<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Repositories') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-4">
                <table class="w-full" cellpadding="0" cellspacing="0" >
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Enlace</th>
                            <th>Descripcion</th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($repositories as $repository)
                            <tr class="pb-2">
                                <td class="text-center">{{ $repository->id }}</td>
                                <td class="text-center">{{ $repository->url }}</td>
                                <td class="text-center">{{ $repository->description }}</td>
                                <td class="px-8 py-2 text-center">
                                    <a class="rounded-md shadow-md bg-green-500 text-white px-12 py-1" href="{{ route('repositories.show', $repository) }}">
                                        Ver
                                    </a>
                                </td>
                                <td class="px-4 py-2 text-center">
                                    <a class="rounded-md shadow-md bg-indigo-700 text-white px-12 py-1" href="{{ route('repositories.edit', $repository) }}">
                                        Editar
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td class="text-center text-red-900 py-3" colspan="5">No hay repositorios creados para este usuario</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="mt-4 text-right py-3 px-6">
                    <a class="rounded-md shadow-md bg-blue-500 text-white px-12 py-2" href="{{ route('repositories.create') }}">Crear repositorio</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
