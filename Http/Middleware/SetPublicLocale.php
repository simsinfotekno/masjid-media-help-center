<?php

namespace Modules\MasjidMediaHelpCenter\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

/**
 * Locale handling for the public help center pages only.
 *
 * Core's `app.locales` config has no 'id' entry, so Helper::setLocale()
 * would silently drop an Indonesian locale. The help center keeps its
 * own session key instead of going through core's locale system.
 */
class SetPublicLocale
{
    const SESSION_KEY = 'mm_helpcenter_locale';
    const DEFAULT_LOCALE = 'id';
    const SUPPORTED = ['id', 'en'];

    public function handle(Request $request, Closure $next)
    {
        $requested = $request->query('lang');

        if ($requested && in_array($requested, self::SUPPORTED, true)) {
            session([self::SESSION_KEY => $requested]);
        }

        $locale = session(self::SESSION_KEY, self::DEFAULT_LOCALE);

        if (!in_array($locale, self::SUPPORTED, true)) {
            $locale = self::DEFAULT_LOCALE;
        }

        app()->setLocale($locale);

        return $next($request);
    }
}
