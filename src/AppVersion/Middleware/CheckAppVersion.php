<?php

namespace Tnlake\Lib\AppVersion\Middleware;

use Tnlake\Lib\Api\Responses\ApiResponse;
use Tnlake\Lib\AppVersion\Services\AppVersionService;
use Closure;
use Illuminate\Http\Request;

class CheckAppVersion
{
    private AppVersionService $versionService;

    public function __construct(AppVersionService $versionService)
    {
        $this->versionService = $versionService;
    }

    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        $appVersion = $request->header("X-App-Version");
        $platform = $request->header("X-App-Platform", "web");

        // バージョンヘッダーがない場合は通す（開発環境など）
        if (!$appVersion) {
            return $next($request);
        }

        // webの場合はバージョンチェックをスキップ
        if ($platform === "web") {
            return $next($request);
        }

        // iOS/Androidのバージョンチェック
        $versionCheck = $this->versionService->checkVersion($appVersion, $platform);

        switch ($versionCheck["status"]) {
            case "force_update":
                // 強制アップデート
                return ApiResponse::forceUpdate($versionCheck["update_url"] ?? null);

            case "update_available":
                // 新バージョン通知（リクエストは通す）
                $response = $next($request);
                return ApiResponse::withNewVersionNotification(
                    $response,
                    $versionCheck["latest"] ?? null,
                    $versionCheck["update_url"] ?? null
                );

            case "ok":
            default:
                // 問題なし
                return $next($request);
        }
    }
}
