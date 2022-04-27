@props(['company'])

<form {{ $attributes }} method="post">
    <div class="flex flex-row mb-4">
        @csrf
        @if (!empty($company->id))
            @method('patch')
        @endif
        <input type="hidden" name="id" value="{{ $company->id }}" />
        <div class="basis-1/2 mr-2">
            <label for="name">Name:</label>
            <input type="text" name="name" value="{{ $company->name }}" required
                class="w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" />
        </div>
        <div class="basis-1/2">
            <label for="email">Email:</label>
            <input type="email" name="email" value="{{ $company->email }}"
                class="w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" />
        </div>
    </div>
    <div class="w-full mb-4">
        <label for="website">Website:</label>
        <input type="url" name="website" value="{{ $company->website }}"
            class="w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" />
    </div>
    <div class="w-full">
        <label for="logo">Logo: </label>
        <input type="file" name="logo" value="{{ $company->logo }}"
            class="w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" />
        @if (!empty($company->logo))
            <img src="{{ asset("storage/$company->logo") }}" />
        @endif
    </div>
    <div class="mt-4">
        <button type="submit"
            class="inline-flex items-center px-4 py-2 bg-blue-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-600 active:bg-blue-600 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
            Save
        </button>
    </div>
</form>
