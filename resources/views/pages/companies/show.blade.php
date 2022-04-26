<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __("Company - $company->name") }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div>
                        <b>Name:</b>
                        <span>{{ $company->name }}</span>
                    </div>
                    <div>
                        <b>Email:</b>
                        <a href="mailto:{{ $company->email }}">{{ $company->email }}</a>
                    </div>
                    <div>
                        <b>Website:</b>
                        <a href="mailto:{{ $company->email }}">{{ $company->email }}</a>
                    </div>
                    <div>
                        <b>Logo:</b>
                        <image class="w-96" src="{{ $company->logo }}" />
                    </div>
                    <div class="flex justify-end pt-4">
                        <a href="{{ route('companies.edit', $company->id) }}"
                            class="inline-flex items-center px-4 py-2 bg-blue-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-600 active:bg-blue-600 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                            Edit
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
