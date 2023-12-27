<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Multi-purpose</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body style="font-family: poppins" class="hold-transition sidebar-mini">
    <div class="wrapper" id="app">

        {{-- header --}}
        @include('admin.layouts.header')

        {{-- sidebar --}}
        @include('admin.layouts.sidebar')

        <div class="content-wrapper">
            <router-view></router-view>
        </div>

        <aside class="control-sidebar control-sidebar-dark">

            <div class="p-3">
                <h5>Title</h5>
                <p>Sidebar content</p>
            </div>
        </aside>

        {{-- footer --}}
        @include('admin.layouts.footer')
    </div>
</body>

</html>
