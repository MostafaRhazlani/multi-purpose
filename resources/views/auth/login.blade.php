<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Multi-Purpose | Log in</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="hold-transition login-page" style="font-family: poppins">
    <div id="app">
        <router-view>

            <auth-login />

        </router-view>

    </div>
</body>

</html>
