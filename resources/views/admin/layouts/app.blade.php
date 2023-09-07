<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title> @yield('title') | {{ config('app.name', 'Maps') }}</title>
    <meta name="description" content="description here">
    <meta name="keywords" content="keywords,here">

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css"
        integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">


    @stack('css')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 font-sans leading-normal tracking-normal">

    @include('admin.layouts.include.nav')
    <!--Container-->
    <div class="container w-full mx-auto mb-8">
        <div class="text-sm breadcrumbs px-3 sm:px-2 md:px-2">
            @yield('breadcrumbs')
        </div>
        <div class="w-full px-4 md:px-0 md:mt-8 mb-16 text-gray-900 leading-normal">
            <!--Console Content-->
            @yield('content')
            <!--/ Console Content-->
        </div>
    </div>
    <!--/container-->

    @yield('modal')
    @include('admin.layouts.include.footer')

    @stack('js')
</body>

</html>
