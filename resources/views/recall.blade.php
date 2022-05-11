<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-800 dark:text-slate-200 leading-tight pl-6">
            {{ __('Recalls') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto pb-12 px-4 sm:px-6 lg:px-8 mt-6">
        <!-- Replace with your content -->
        <recall-search />
    </div>
</x-app-layout>
