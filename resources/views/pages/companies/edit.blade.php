<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __("Edit Company - $company->name") }}
        </h2>
    </x-slot>
    <div class="flex justify-end pt-4">
        <form action="{{ route('companies.destroy', $company->id) }}" method="post">
            @csrf
            @method('delete')
            <button type="submit"
                class="inline-flex items-center px-4 py-2 bg-red-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-600 active:bg-red-600 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                Delete
            </button>
        </form>
    </div>
    <x-company-form :company="$company" method="patch" action="{{ route('companies.update', $company->id) }}"
        enctype="multipart/form-data" />
</x-app-layout>
