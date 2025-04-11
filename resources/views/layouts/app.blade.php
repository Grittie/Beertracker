<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title> Beertracker | Easy Beer Cost Tracking with Friends </title>

    <!-- Primary Meta Tags -->
    <meta name="title" content="Beertracker | Easy Beer Cost Tracking with Friends">
    <meta name="description" content="Beertracker is your go-to site for tracking the amount of beer everyone is pitching in for – no tikkies, no stress.">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://beertracker.nl/">
    <meta property="og:title" content="Beertracker">
    <meta property="og:description" content="Track who owes beers the smart way.">
    <meta property="og:image" content="https://beertracker.nl/images/preview_banner.png"> <!-- optional preview image -->

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="https://beertracker.nl/">
    <meta property="twitter:title" content="Beertracker">
    <meta property="twitter:description" content="Track who owes beers the smart way.">
    <meta property="twitter:image" content="https://beertracker.nl/images/preview.png"> <!-- optional preview image -->

    <!-- Site Name (for Google) -->
    <meta property="og:site_name" content="Beertracker">

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

    <!-- Structured Data (JSON-LD) -->
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "WebSite",
      "url": "https://beertracker.nl",
      "name": "Beertracker"
    }
    </script>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet"/>

    <!-- Flatpickr CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <!-- Flatpickr JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Styles -->
    @livewireStyles
</head>
<body class="font-sans antialiased">
<x-banner/>
<div class="min-h-screen bg-gray-100">
    @livewire('navigation-menu')


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

@stack('modals')

@livewireScripts
</body>
</html>
