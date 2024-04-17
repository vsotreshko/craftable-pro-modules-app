<!DOCTYPE html>
<html class="h-full bg-gray-100/50" lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

    <title>{{ ___('craftable-pro', 'Craftable PRO') }}</title>

    @routes

    @vite(['resources/js/craftable-pro/index.ts', 'resources/css/craftable-pro.css'])

    @inertiaHead
</head>

<body class="h-full">
    @inertia
</body>

</html>
