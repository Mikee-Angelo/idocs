@section('title', 'Create')
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create User') }}
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
                    
                    <form action="{{route('manage-users.store')}}" method="post">
                        @csrf

                         <!-- Role -->
                        <div>
                            <x-label for="role" :value="__('Assign Role')" />

                            <select
                                class="block w-full text-gray-700 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500"
                                name="role">
                                <option value="">
                                    Select an option
                                </option>
                                @foreach ($roles as $role)
                                     <option value="{{ $role->id }}">
                                    {{ $role->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <!-- Name -->
                        <div class="mt-3">
                            <x-label for="name" :value="__('Name')" />

                            <x-input id="name" class="block mt-1 w-full" type="text" name="name"
                                :value="old('name')" required autofocus />
                        </div>

                        <!-- Email -->
                        <div class="mt-3">
                            <x-label for="email" :value="__('Email')" />

                            <x-input id="email" class="block mt-1 w-full" type="email" name="email"
                                :value="old('email')" required autofocus />
                        </div>



                         <!-- Campus -->
                        <div class="mt-3">
                            <x-label for="campus" :value="__('Campus')" />

                            <select
                                class="block w-full text-gray-700 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500"
                                name="campus">
                                <option value="">
                                    Select an option
                                </option>
                                @foreach ($campuses as $campus)
                                     <option value="{{ $campus->id }}">
                                    {{ $campus->campus_name }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <x-button class="mt-3">
                            {{ __('Create') }}
                        </x-button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
