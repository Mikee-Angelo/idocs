@section('title', 'Document Management System')
<x-guest-layout>

<main class="dark:bg-gray-800 bg-white relative overflow-hidden h-screen">
    <header class="h-24 sm:h-32 flex items-center z-30 w-full">
        
    </header>
    <div class="flex relative z-20 items-center">
        <div class="container mx-auto px-6 flex flex-col justify-between items-center relative py-4">
            <div class="flex flex-col">
                <x-application-logo class="h-24 w-24 self-center"></x-application-logo>
                <p class="text-3xl my-6 text-center dark:text-white">
                   President Ramon Magsaysay State University
                </p>
                <h2 class="max-w-3xl text-5xl md:text-5xl font-bold mx-auto dark:text-white text-gray-800 text-center py-2">
                    IDocs - Document Management System
                </h2>
                <div class="flex items-center justify-center mt-4">
                    <a href="{{ route('login') }}" class="uppercase py-3 my-2 px-7 md:mt-16 bg-transparent dark:text-gray-800 dark:bg-white hover:dark:bg-gray-100 border-2 border-gray-800 text-gray-800 dark:text-white hover:bg-gray-800 hover:text-white text-md">
                        Login
                    </a>
                </div>
            </div>
        </div>
    </div>
</main>

</x-guest-layout>