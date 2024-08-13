<!-- meta tags and other links -->
<!DOCTYPE html>
<html lang="en" data-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Nexada</title>
    <link rel="icon" type="image/png" href="{{ asset(favionLogoUrl()) }}" sizes="16x16">

    @include('admin.layouts.headerlinks')

</head>

<body>
    
    @include('admin.layouts.sidebar')

    <main class="dashboard-main">
        
        @include('admin.layouts.header')
        <div class="container mt-3">
            <!-- Display error message -->
            @if (Session::has('error'))
                <div class="alert alert-danger alert-dismissible fade show justify-content-around" role="alert">
                    {{ Session::get('error') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    </button>
                </div>
            @endif
    
            <!-- Display success message -->
            @if (Session::has('success'))
                <div class="alert alert-success alert-dismissible fade show d-flex justify-content-between" role="alert">
                    {{ Session::get('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    </button>
                </div>
            @endif
        </div>
        @yield('content')
        
        @include('admin.layouts.footer')
        
    </main>

    @include('admin.layouts.footerlinks')

    @yield('script-js')
</body>

</html>
