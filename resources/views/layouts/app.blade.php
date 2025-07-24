<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>
  {{-- Bootstrap CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />

    {{-- DataTables CSS (you can move it here too) --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

<style>
    [x-cloak] { display: none; }
    /* Fix the width and spacing of the 'Show entries' select dropdown */
    div.dataTables_length select {
        width: auto !important;     /* auto width based on content */
        min-width: 60px;            /* ensure minimum width */
        padding: 4px 8px;           /* inner padding */
        border: 1px solid #ccc;     /* optional: add border */
        border-radius: 4px;         /* smooth corners */
        background-color: white;    /* ensure background visibility */
    }

    /* Optional: align the label and select nicely */
    div.dataTables_length label {
        display: flex;
        align-items: center;
        gap: 8px; /* space between "Show" and dropdown */
    }
</style>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
        
    {{-- jQuery + DataTables + Bootstrap JS --}}
     <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    {{-- Blade stack to include custom scripts --}}
    @stack('scripts')
    </body>
</html>
