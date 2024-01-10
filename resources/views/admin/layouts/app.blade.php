<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ setting('page_name') }}</title>

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

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const toggleMenuIcon = document.getElementById('toggleMenu');
            const body = document.querySelector('body');

            toggleMenuIcon.addEventListener('click', () => {
                if(body.classList.contains('sidebar-collapse')) {
                    localStorage.setItem('sidebarState', 'expanded');
                } else {
                    localStorage.setItem('sidebarState', 'collapsed');
                }
            });

            const sidebarState = localStorage.getItem('sidebarState');

            if(sidebarState === 'collapsed') {
                body.classList.add('sidebar-collapse');
            } else {
                body.classList.remove('sidebar-collapse');
            }
        })
    </script>
</body>

</html>
