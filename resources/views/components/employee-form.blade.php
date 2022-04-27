@props(['employee', 'companies'])

<form {{ $attributes }} method="post">
    @csrf
    @if (!empty($employee->id))
        @method('patch')
    @endif
    <div class="flex flex-row mb-4">
        <input type="hidden" name="id" value="{{ $employee->id }}" />
        <div class="basis-1/2 mr-2">
            <label for="name">First Name:</label>
            <input type="text" name="first_name" value="{{ $employee->first_name }}" required
                class="w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" />
        </div>
        <div class="basis-1/2">
            <label for="name">Last Name:</label>
            <input type="text" name="last_name" value="{{ $employee->last_name }}" required
                class="w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" />
        </div>

    </div>
    <div class="flex flex-row mb-4">
        <div class="basis-1/2 mr-2">
            <label for="company">Company:</label>
            <select name="company"
                class="w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                <option value="0" disabled @if (empty($employee->company_id)) selected @endif>
                    Select the Company that the Employee belongs too...
                </option>
                @foreach ($companies as $company)
                    <option value="{{ $company->id }}" @if ($company->id === $employee->company_id) selected @endif>
                        {{ $company->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="basis-1/2">
            <label for="email">Email:</label>
            <input type="email" name="email" value="{{ $employee->email }}"
                class="w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" />
        </div>
    </div>
    <div class="flex flex-row mb-4">
        <div class="basis-1/2">
            <label for="website">Phone:</label>
            <input type="tel" name="phone" value="{{ $employee->phone }}"
                class="w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" />
        </div>
    </div>
    <div class="mt-4">
        <button type="submit"
            class="inline-flex items-center px-4 py-2 bg-blue-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-600 active:bg-blue-600 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
            Save
        </button>
    </div>
</form>
