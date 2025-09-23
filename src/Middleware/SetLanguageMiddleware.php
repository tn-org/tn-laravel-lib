<?php

namespace Tnlake\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLanguageMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $supportedLanguages = ["ja", "en"];
        $fallbackLanguage = "ja";

        $language = $this->determineLanguage($request, $supportedLanguages, $fallbackLanguage);

        // Set application language
        app()->setLocale($language);

        return $next($request);
    }

    /**
     * Determine the language to use based on priority
     */
    private function determineLanguage(Request $request, array $supportedlanguages, string $fallbacklanguage): string
    {
        // Priority 1: Authenticated user's setting
        $user = $request->user();
        if ($user) {
            if ($user->language && in_array($user->language, $supportedlanguages)) {
                return $user->language;
            }
        }

        // Priority 2: Custom header (X-App-Language)
        $customlanguage = $request->header("X-App-Language");
        if ($customlanguage && in_array($customlanguage, $supportedlanguages)) {
            return $customlanguage;
        }

        // Priority 3: Accept-Language header
        $acceptLanguage = $request->getPreferredLanguage($supportedlanguages);
        if ($acceptLanguage) {
            return $acceptLanguage;
        }

        // Fallback
        return $fallbacklanguage;
    }
}
