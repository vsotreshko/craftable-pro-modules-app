<?php

namespace App\Http\Middleware;

use Brackets\CraftablePro\Settings\GeneralSettings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Inertia\Middleware;

class LocalHandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     *
     * @var string
     */
    protected $rootView = 'craftable-pro';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Defines the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     */
    public function share(Request $request): array
    {
        // Load list of used modules
        $modulesPathPrefix = base_path().'/vendor/brackets/';
        $modulesPath = $modulesPathPrefix.'*';
        $modulesFullPath = glob($modulesPath, GLOB_ONLYDIR);
        $modules = array_map(
            function ($str) use ($modulesPathPrefix) {
                return str_replace($modulesPathPrefix, '', $str);
            },
            $modulesFullPath
        );
        //

        $settings = app(GeneralSettings::class);

        $showTwoFactorAuthCTA = $this->showTwoFactorAuthCTA($request);

        return array_merge(parent::share($request), [
            'auth' => [
                'user' => fn () => $request->user('craftable-pro') ? $request->user('craftable-pro')->only('id', 'first_name', 'last_name', 'email', 'initials', 'avatar_url', 'locale') : null,
                'permissions' => fn () => $request->user('craftable-pro') ? $request->user('craftable-pro')->getAllPermissions()->pluck('name') : [],
                'showTwoFactorCTA' => fn () => $showTwoFactorAuthCTA,
            ],
            'message' => fn () => $request->session()->get('message'),
            'sort' => fn () => $request->get('sort'),
            'filter' => fn () => $request->get('filter'),
            'csrf_token' => csrf_token(),
            'config' => [
                'craftable_pro' => [
                    'track_user_last_active_time' => config('craftable-pro.track_user_last_active_time', false),
                ],
                'socialite' => [
                    'microsoft' => config('craftable-pro.social_login.allowed_services.microsoft', false),
                    'github' => config('craftable-pro.social_login.allowed_services.github', false),
                    'google' => config('craftable-pro.social_login.allowed_services.google', false),
                    'twitter' => config('craftable-pro.social_login.allowed_services.twitter', false),
                    'facebook' => config('craftable-pro.social_login.allowed_services.facebook', false),
                    'apple' => config('craftable-pro.social_login.allowed_services.apple', false),
                ],
                'media_library' => [
                    'max_file_size' => config('media-library.max_file_size', 1024 * 1024 * 2),
                ],
            ],
            'settings' => [
                'available_locales' => $settings->available_locales,
                'default_locale' => $settings->default_locale,
            ],
            'modules' => $modules,
        ]);
    }

    /**
     * @author odziomkovak
     */
    private function showTwoFactorAuthCTA(Request $request): bool
    {
        $showTwoFactorAuthCTA = false;

        $twoFactorAuthRequired = $request->user('craftable-pro')
            && ! $request->user('craftable-pro')->hasEnabledTwoFactorAuthentication()
            && $request->user('craftable-pro')->hasRequiredTwoFactorAuthentication;

        // the user will see the modal only once in 24 hours
        if ($twoFactorAuthRequired && ! $request->cookie('twoFactorAuthCTAShown')) {
            $showTwoFactorAuthCTA = true;
            Cookie::queue('twoFactorAuthCTAShown', true, 60 * 24);
        }

        return $showTwoFactorAuthCTA;
    }
}
