<div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-slate-100 dark:bg-slate-500">
    <div>
        {{ $logo }}
    </div>

    <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white dark:bg-slate-600 shadow-md overflow-hidden sm:rounded-lg">
        {{ $slot }}
    </div>

    {{ isset($footer)?$footer: '' }}
</div>
