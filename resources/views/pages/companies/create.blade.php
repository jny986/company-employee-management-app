<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Company') }}
        </h2>
    </x-slot>
    <x-company-form :company="$company" method="post" action="{{ route('companies.store') }}"
        enctype="multipart/form-data" />
</x-app-layout>
