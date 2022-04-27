<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __("Company - $company->name") }}
        </h2>
    </x-slot>
    <div class="flex justify-end pt-4">
        <a href="{{ route('companies.edit', $company->id) }}"
            class="inline-flex items-center px-4 py-2 bg-blue-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-600 active:bg-blue-600 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
            Edit
        </a>
    </div>
    <div class="flex flex-row mb-4">
        <div class="basis-1/2">
            <b>Name:</b>
            <span>{{ $company->name }}</span>
        </div>
        <div class="basis-1/2">
            <b>Email:</b>
            <a href="mailto:{{ $company->email }}">{{ $company->email }}</a>
        </div>
    </div>
    <div class="w-full mb-4">
        <b>Website:</b>
        <a href="{{ $company->email }}">{{ $company->email }}</a>
    </div>
    <div class="w-full">
        <b class="justify-self-left">Logo: </b>
        <image class="w-96 justify-self-center" src="{{ asset("storage/$company->logo") }}" />
    </div>
    <div class="mt-8">
        <h2 class="font-bold text-2xl mb-4">Employees</h2>
        @if ($employees->count() > 0)
            <table class="w-full">
                <thead class="w-full">
                    <tr>
                        <th class="w-2/12">First Name</th>
                        <th class="w-2/12">Last Name</th>
                        <th class="w-2/6">Email</th>
                        <th class="w-2/12">Phone</th>
                        <th class="w-1/12"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($employees as $employee)
                        <tr>
                            <td>
                                {{ $employee->first_name }}
                            </td>
                            <td>
                                {{ $employee->last_name }}
                            </td>
                            <td>
                                <a href="mailto:{{ $employee->email }}">
                                    {{ $employee->email }}
                                </a>
                            </td>
                            <td>
                                <a href="tel:{{ $employee->phone }}">
                                    {{ $employee->phone }}
                                </a>
                            </td>
                            <td>
                                {{-- ToDo: Add link to Employees --}}
                                <a href="">
                                    <x-show-icon class="w-6 float-right" />
                                </a>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $employees->onEachSide(5)->links() }}
        @else
            <p class="text-center">Sorry No Employees Yet</p>
        @endif
    </div>
</x-app-layout>
