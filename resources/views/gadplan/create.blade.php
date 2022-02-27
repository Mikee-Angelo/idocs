@section('title', 'GAD Plan Item Create')
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Item') }}
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
                    <form action="{{ route('gadplans.store')}}" method="post">
                        @csrf
                        <!-- Gender Issue and Mandate -->
                        <div>
                            <x-label for="gad_issue_mandate" :value="__('Gender Issue and/or GAD Mandate')" />

                            <x-input id="gad_issue_mandate" class="block mt-1 w-full" type="text"
                                name="gad_issue_mandate" :value="old('gad_issue_mandate')" required autofocus />
                        </div>

                        <!-- Cause of the Gender Issue -->
                        <div class="mt-3">
                            <x-label for="cause_of_issue" :value="__('Cause of the Gender Issue')" />

                            <x-input id="cause_of_issue" class="block mt-1 w-full" type="text" name="cause_of_issue"
                                :value="old('cause_of_issue')" required autofocus />
                        </div>

                        <!-- GAD result statement/GAD Objective -->
                        <div class="mt-3">
                            <x-label for="gad_statement_objective"
                                :value="__('GAD Result Statement / GAD Objective')" />

                            <x-input id="gad_statement_objective" class="block mt-1 w-full" type="text"
                                name="gad_statement_objective" :value="old('gad_statement_objective')" required
                                autofocus />
                        </div>

                        <!-- Relevant Agencies -->
                        <div class="mt-3">
                            <x-label for="cause_of_issue" :value="__('Relevant Agencies')" />

                            <select
                                class="block w-full text-gray-700 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500"
                                name="relevant_agencies">
                                <option value="">
                                    Select an option
                                </option>
                                @foreach ($agencies as $agency)
                                    <option value="{{ $agency->id }}">
                                        {{ $agency->name }}
                                    </option>
                                @endforeach
                            </select>

                        </div>

                        <!-- GAD Activity -->
                        <div class="mt-3">
                            <x-label for="gad_activity" :value="__('GAD Activity')" />

                            <x-input id="gad_activity" class="block mt-1 w-full" type="text" name="gad_activity"
                                :value="old('gad_activity')" required autofocus />
                        </div>

                        <!-- Output Performace Indicator and Target -->
                        <div class="mt-3">
                            <x-label for="indicator_target" :value="__('Output Performace Indicator and Target')" />

                            <x-input id="indicator_target" class="block mt-1 w-full" type="text" name="indicator_target"
                                :value="old('indicator_target')" required autofocus />
                        </div>

                        <!-- Budgetary Requirement -->
                        <div class="mt-3">
                            <x-label for="budget_requirement" :value="__('Budgetary Requirement')" />

                            <x-input id="budget_requirement" class="block mt-1 w-full" type="number"
                                name="budget_requirement" :value="old('budget_requirement')" required autofocus />
                        </div>

                        <!-- Source of Budget -->
                        <div class="mt-3">
                            <x-label for="budget_source" :value="__('Source of Budget')" />

                            <x-input id="budget_source" class="block mt-1 w-full" type="number" name="budget_source"
                                value="GAA" required autofocus disabled
                                placeholder="GAA" />
                        </div>

                        <!-- Responsible Unit -->
                        <div class="mt-3">
                            <x-label for="cause_of_issue" :value="__('Responsible Unit')" />

                            <select
                                class="block w-full text-gray-700 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500"
                                name="responsible_unit">
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

                        <x-button class="mt-5">
                            {{ __('Create') }}
                        </x-button>

                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
