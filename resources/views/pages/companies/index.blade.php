<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Companies') }}
        </h2>
    </x-slot>
    <div class="flex justify-end pt-4">
        <a href="{{ route('companies.create') }}"
            class="inline-flex items-center px-4 py-2 bg-blue-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-600 active:bg-blue-600 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
            Create
        </a>
    </div>
    @if ($companies->count() > 0)
        <table class="p-4">
            <thead class="mb-4">
                <tr class="border-grey-500">
                    <th class="w-1/6 p-2">Name</th>
                    <th class="w-1/6 p-2">Email</th>
                    <th class="w-1/6 p-2">Logo</th>
                    <th class="w-2/6 p-2">Website</th>
                    <th class="w-1/12 p-2"></th>
                </tr>
            <tbody>
                @foreach ($companies as $company)
                    <tr>
                        <td class="p-2">
                            {{ $company->name }}
                        </td>
                        <td class="p-2">
                            <a href="mailto:{{ $company->email }}">{{ $company->email }}</a>
                        </td>
                        <td class="p-4">
                            <img src="{{ $company->logo }}" />
                        </td>
                        <td class="p-2">
                            <a href="{{ $company->website }}">{{ $company->website }}</a>
                        </td>
                        <td>
                            <a href="{{ route('companies.show', $company->id) }}">
                                <x-show-icon class="w-6 float-right" />
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $companies->onEachSide(5)->links() }}
    @else
        <div>
            Sorry No Companies Yet
        </div>
    @endif
</x-app-layout>
