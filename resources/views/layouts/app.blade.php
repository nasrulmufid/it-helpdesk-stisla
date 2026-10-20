<!DOCTYPE html>
<html lang="id" data-theme="light">

<head>
    @include('layouts.partials.head')
</head>

<body>
    @include('layouts.partials.flash')

    <div class="app-shell" data-stisla-app-shell>
        @include('layouts.partials.sidebar')

        <main class="app-shell__main">
            @include('layouts.partials.navbar')

            <div class="page content">
                <div class="content__container">
                    @yield('content')
                </div>
            </div>
        </main>
    </div>
</body>

</html>
