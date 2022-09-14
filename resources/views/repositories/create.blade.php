<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Repositories') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-4">
                <form class="max-w-md" action="{{ route('repositories.store') }}" method="POST">
                    @csrf

                    <label class="blog font-medium text-sm text-gray-700" for="">URL *</label>
                    <input class="form-input w-full rounded-md shadow-sm" type="text" name="url" >

                    <label class="blog font-medium text-sm text-gray-700" for="">Description*</label>
                    <textarea class="form-input w-full rounded-md shadow-sm" type="text" name="description">
                    </textarea>

                    <hr class="my-4">

                    <input class="bg-blue-500 text-white font-bold py-2 px-6 rounded-md cursor-pointer" type="submit" value="Guardar">
                    <a class="bg-gray-300 text-black font-bold py-2 px-4 rounded-md" href="{{ route('repositories.index') }}">Volver</a>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
