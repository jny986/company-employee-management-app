<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __("Employee - $employee->first_name $employee->last_name") }}
        </h2>
    </x-slot>
    <div class="flex justify-end pt-4">
        <a href="{{ route('employees.edit', $employee->id) }}"
            class="inline-flex items-center px-4 py-2 bg-blue-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-600 active:bg-blue-600 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
            Edit
        </a>
    </div>
    <div class="flex flex-row mb-4">
        <div class="basis-1/2">
            <b>First Name:</b>
            <span>{{ $employee->first_name }}</span>
        </div>
        <div class="basis-1/2">
            <b>Last Name:</b>
            <span>{{ $employee->last_name }}</span>
        </div>
    </div>
    <div class="flex flex-row mb-4">
        <div class="basis-1/2">
            <b>Company:</b>
            <a href={{ route('companies.show', $employee->company_id) }}>{{ $employee?->company?->name }}</a>
        </div>
        <div class="basis-1/2">
            <b>Email:</b>
            <a href="mailto:{{ $employee->email }}">{{ $employee->email }}</a>
        </div>
    </div>
    <div class="flex flex-row mb-4">
        <div class="basis-1/2">
            <b>Phone:</b>
            <a href="tel:{{ $employee->phone }}">{{ $employee->phone }}</a>
        </div>
    </div>
</x-app-layout>
