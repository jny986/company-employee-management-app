<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Employees') }}
        </h2>
    </x-slot>
    <div class="flex justify-end pt-4">
        <a href="{{ route('employees.create') }}"
            class="inline-flex items-center px-4 py-2 bg-blue-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-600 active:bg-blue-600 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
            Create
        </a>
    </div>
    @if ($employees->count() > 0)
        <table class="p-4">
            <thead class="mb-4">
                <tr class="border-grey-500">
                    <th class="w-1/6 p-2">First Name</th>
                    <th class="w-1/6 p-2">Last Name</th>
                    <th class="w-3/12 p-2">Company</th>
                    <th class="w-1/6 p-2">Email</th>
                    <th class="w-1/6 p-2">Phone</th>
                    <th class="w-1/12 p-2"></th>
                </tr>
            <tbody>
                @foreach ($employees as $employee)
                    <tr>
                        <td class="p-2">
                            {{ $employee->first_name }}
                        </td>
                        <td class="p-2">
                            {{ $employee->last_name }}
                        </td>
                        <td class="p-2">
                            <a
                                href="{{ route('companies.show', $employee->company_id) }}">{{ $employee?->company?->name }}</a>
                        </td>
                        <td class="p-2">
                            <a href="mailto:{{ $employee->email }}">{{ $employee->email }}</a>
                        </td>
                        <td class="p-2">
                            <a href="tel:{{ $employee->phone }}">{{ $employee->phone }}</a>
                        </td>
                        <td>
                            <a href="{{ route('employees.show', $employee->id) }}">
                                <x-show-icon class="w-6 float-right" />
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $employees->onEachSide(5)->links() }}
    @else
        <div>
            Sorry No Employees Yet
        </div>
    @endif
</x-app-layout>
