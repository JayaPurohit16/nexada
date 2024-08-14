<?php

use App\Models\CmsSettting;
use Illuminate\Support\Facades\File;


function appLogoUrl()
{
    static $appLogoUrl;

    if ($appLogoUrl === null) {
        $appLogo = CmsSettting::where('key', 'website_logo')->first();
        $appLogoUrl = $appLogo->value && File::exists(public_path($appLogo->value)) 
            ? $appLogo->value 
            : 'assets/images/logo/app-logo.jpg';
    }

    return $appLogoUrl;
}

function favionLogoUrl()
{
    static $faviconLogoUrl;

    if ($faviconLogoUrl === null) {
        $favionLogo = CmsSettting::where('key', 'favicon_logo')->first();
        $faviconLogoUrl = $favionLogo->value && File::exists(public_path($favionLogo->value))
            ? $favionLogo->value
            : 'assets/images/logo/favicon-logo.jpg';
    }

    return $faviconLogoUrl;
}

function siteVersion()
{
    static $siteVersion;

    if ($siteVersion === null) {
        $version = CmsSettting::where('key', 'version')->first();
        $siteVersion = $version->value ? $version->value : 'v1.0.0';
    }
    return $siteVersion;
}
