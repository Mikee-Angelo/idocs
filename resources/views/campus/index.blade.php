@section('title', 'Campus/College')
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Campus/College') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
             <div class="flex flex-row-reverse mb-3">
                <x-link href="{{route('campus.create')}}" class="ml-3 w-32">
                    {{ __('Compose') }}
                </x-link>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <x-campus-table></x-campus-table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>


