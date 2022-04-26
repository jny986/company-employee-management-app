<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Companies') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="w-full">

                    </div>
                    @if ($companies->count() > 0)
                        <table class="p-4">
                            <thead class="mb-4">
                                <tr class="border-grey-500">
                                    <th class="w-1/6 p-2">Name</th>
                                    <th class="w-1/6 p-2">Email</th>
                                    <th class="w-1/6 p-2">Logo</th>
                                    <th class="w-2/6 p-2">Website</th>
                                    <th class="w-1/6 p-2"></th>
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
                                                <x-show-icon class="text-large" />
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
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
