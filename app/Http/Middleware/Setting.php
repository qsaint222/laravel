<?php

namespace App\Http\Middleware;

use App\Facades\UtilityFacades;
use Closure;
use Illuminate\Http\Request;

class Setting
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        config([
            'services.google.client_id' => UtilityFacades::getsettings('GOOGLE_CLIENT_ID', ''),
            'services.google.client_secret' => UtilityFacades::getsettings('GOOGLE_CLIENT_SECRET', ''),
            'services.google.redirect' => UtilityFacades::getsettings('GOOGLE_REDIRECT', ''),

            'services.facebook.client_id' => UtilityFacades::getsettings('FACEBOOK_CLIENT_ID', ''),
            'services.facebook.client_secret' => UtilityFacades::getsettings('FACEBOOK_CLIENT_SECRET', ''),
            'services.facebook.redirect' => UtilityFacades::getsettings('FACEBOOK_REDIRECT', ''),

            'services.github.client_id' => UtilityFacades::getsettings('GITHUB_CLIENT_ID', ''),
            'services.github.client_secret' => UtilityFacades::getsettings('GITHUB_CLIENT_SECRET', ''),
            'services.github.redirect' => UtilityFacades::getsettings('GITHUB_REDIRECT', ''),

            'services.linkedin.client_id' => UtilityFacades::getsettings('LINKEDIN_CLIENT_ID', ''),
            'services.linkedin.client_secret' => UtilityFacades::getsettings('LINKEDIN_CLIENT_SECRET', ''),
            'services.linkedin.redirect' => UtilityFacades::getsettings('LINKEDIN_REDIRECT', ''),

        ]);
        return $next($request);
    }
}
