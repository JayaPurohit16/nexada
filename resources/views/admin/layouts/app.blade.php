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
                <div class="alert alert-danger bg-danger-100 text-danger-600 border-danger-100 px-24 py-11 mb-0 fw-semibold text-lg radius-8" role="alert">
                    <div class="d-flex align-items-center justify-content-between text-lg">
                        {{ Session::get('error') }} 
                        <button class="remove-button text-danger-600 text-xxl line-height-1"> <iconify-icon icon="iconamoon:sign-times-light" class="icon"></iconify-icon></button>
                    </div>
                </div>
            @endif
    
            <!-- Display success message -->
            @if (Session::has('success'))
                <div class="alert alert-success bg-success-100 text-success-600 border-success-100 px-24 py-11 mb-0 fw-semibold text-lg radius-8" role="alert">
                    <div class="d-flex align-items-center justify-content-between text-lg">
                        {{ Session::get('success') }}
                        <button class="remove-button text-success-600 text-xxl line-height-1"> <iconify-icon icon="iconamoon:sign-times-light" class="icon"></iconify-icon></button>
                    </div>
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
