@section('title', 'Compose | Proposal')
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Compose Proposal') }}
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
                    
                    <form action="{{route('proposals.store')}}" method="post" enctype="multipart/form-data">
                        @csrf

                        <!-- GAD -->
                        <div class="mt-3">
                            <x-label for="gadplan_id" :value="__('GAD Plan')" />

                            <select
                                class="block w-full text-gray-700 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500"
                                name="gadplan_id">
                                <option value="">
                                    Select an option
                                </option>
                                @foreach ($gadplans as $gadplan)
                                     <option value="{{ $gadplan->id }}">
                                    {{ $gadplan->user_id }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <x-dropzone name="file"></x-dropzone>
                        
                        <x-button class="mt-3">
                            {{ __('Create') }}
                        </x-button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
