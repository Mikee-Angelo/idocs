@section('title', 'Register Campus')
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Register Campus') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <!-- Validation Errors -->
                    <x-auth-validation-errors class="mb-4" :errors="$errors" />

                    @if(session('status'))
                        <div class="bg-green-200 border-green-600 text-green-600 border-l-4 p-4 mb-3" role="alert">
                            <p class="font-bold">
                                {{ session('status')['title'] }}
                            </p>
                            <p>
                                {{ session('status')['description'] }}
                            </p>
                        </div>
                    @endif
                    
                    <form action="{{route('campus.store')}}" method="post">
                        @csrf
                        <!-- Campus Name -->
                        <div>
                            <x-label for="campus_name" :value="__('Campus Name')" />

                            <x-input id="campus_name" class="block mt-1 w-full" type="text" name="campus_name"
                                :value="old('campus_name')" required autofocus />
                        </div>

                        <!-- Address -->
                        <div class="mt-3">
                            <x-label for="address" :value="__('Address')" />

                            <x-input id="address" class="block mt-1 w-full" type="text" name="address"
                                :value="old('address')" required autofocus />
                        </div>

                        <!-- Header Address -->
                        <div class="mt-3">
                            <x-label for="letter_header" :value="__('Letter Header')" />

                            <x-input id="letter_header" class="block mt-1 w-full" type="text" name="letter_header"
                                :value="old('letter_header')" required autofocus />
                        </div>

                        <!-- Status -->
                        <div class="block mt-3">
                            <label for="status" class="inline-flex items-center">
                                <input id="status" type="checkbox"
                                    class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                    name="status" checked>
                                <span class="ml-2 text-sm text-gray-600">{{ __('Status') }}</span>
                            </label>
                        </div>

                        <x-button class="mt-3">
                            {{ __('Add') }}
                        </x-button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
