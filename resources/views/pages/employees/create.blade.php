<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Employee') }}
        </h2>
    </x-slot>
    <x-employee-form :employee="$employee" :companies="$companies" action="{{ route('companies.store') }}"
        enctype="multipart/form-data" />
</x-app-layout>
