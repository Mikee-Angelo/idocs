@section('title', 'Create Source of Budget')
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
                    
                    <form action="{{route('budget-sources.store')}}" method="post">
                        @csrf
                        <!-- Campus Name -->
                        <div>
                            <x-label for="name" :value="__('Source Name')" />

                            <x-input id="name" class="block mt-1 w-full" type="text" name="name"
                                :value="old('name')" required autofocus />
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
