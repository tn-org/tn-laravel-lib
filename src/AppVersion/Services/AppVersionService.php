<?php

namespace Tnlake\Lib\AppVersion\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Config;

class AppVersionService
{
    /**
     * iOSの最新バージョン情報を取得
     */
    public function getIosLatestVersion(): ?array
    {
        $cacheKey = Config::get("tnlib.app_version.cache_key");
        return Cache::get($cacheKey);
    }

    /**
     * 強制的にバージョン情報を更新
     */
    public function refreshVersions(): ?array
    {
        $cacheKey = Config::get("tnlib.app_version.cache_key");

        // 新しいバージョン情報を取得
        $versionInfo = $this->fetchIosVersionFromAppStore();

        if ($versionInfo) {
            // 成功したら永続保存で更新
            Cache::forever($cacheKey, $versionInfo);
            return $versionInfo;
        }

        // 失敗した場合は既存のキャッシュを保持
        return Cache::get($cacheKey);
    }

    /**
     * バージョンチェック
     */
    public function checkVersion(string $currentVersion, string $platform): array
    {
        // 最小必須バージョンをconfigから取得
        $minimumVersion = Config::get("tnlib.app_version.min_versions.{$platform}");

        if (!$minimumVersion) {
            return [
                "status" => "ok",
                "current" => $currentVersion
            ];
        }

        // 最小必須バージョン未満は強制アップデート
        if (version_compare($currentVersion, $minimumVersion, "<")) {
            return [
                "status" => "force_update",
                "current" => $currentVersion,
                "minimum" => $minimumVersion,
                "update_url" => $this->getStoreUrl($platform)
            ];
        }

        // iOSの場合は最新バージョンもチェック
        if ($platform === "ios") {
            $versionInfo = $this->getIosLatestVersion();
            if ($versionInfo && isset($versionInfo["version"])) {
                $latestVersion = $versionInfo["version"];

                // バージョンが古い場合
                if (version_compare($currentVersion, $latestVersion, "<")) {
                    // リリース日時から6時間以内は猶予期間（配信遅延を考慮）
                    if (
                        isset($versionInfo["release_date"]) &&
                        $this->isWithinGracePeriod($versionInfo["release_date"], 6)
                    ) {
                        // 猶予期間中は通知しない
                        return [
                            "status" => "ok",
                            "current" => $currentVersion,
                            "latest" => $latestVersion,
                            "in_grace_period" => true
                        ];
                    }

                    return [
                        "status" => "update_available",
                        "current" => $currentVersion,
                        "latest" => $latestVersion,
                        "update_url" => $this->getStoreUrl($platform)
                    ];
                }
            }
        }

        return [
            "status" => "ok",
            "current" => $currentVersion
        ];
    }

    /**
     * iOS App Storeから最新バージョンを取得
     */
    private function fetchIosVersionFromAppStore(): ?array
    {
        $appId = Config::get("tnlib.app_version.ios_app_id");

        try {
            $response = Http::timeout(5)->get(Config::get("tnlib.app_version.itunes_lookup_url"), [
                "id" => $appId,
                "country" => Config::get("tnlib.app_version.itunes_country")
            ]);

            if ($response->successful()) {
                $data = $response->json();

                if (isset($data["results"][0])) {
                    $result = $data["results"][0];
                    return [
                        "version" => $result["version"] ?? null,
                        "release_date" => $result["currentVersionReleaseDate"] ?? null
                    ];
                }
            }
        } catch (\Exception $e) {
            Log::error("Failed to fetch iOS version from App Store", [
                "error" => $e->getMessage(),
                "app_id" => $appId
            ]);
        }

        return null;
    }

    /**
     * リリース日時から猶予期間内かチェック
     */
    private function isWithinGracePeriod(string $releaseDate, int $graceHours): bool
    {
        try {
            $releaseTime = strtotime($releaseDate);
            if (!$releaseTime) {
                return false;
            }

            $currentTime = time();
            $elapsedHours = ($currentTime - $releaseTime) / 3600;

            return $elapsedHours < $graceHours;
        } catch (\Exception $e) {
            Log::warning("Failed to check grace period", [
                "release_date" => $releaseDate,
                "error" => $e->getMessage()
            ]);
            return false;
        }
    }

    /**
     * ストアURLを取得
     */
    private function getStoreUrl(string $platform): string
    {
        switch ($platform) {
            case "ios":
                $appId = Config::get("tnlib.app_version.ios_app_id");
                $baseUrl = Config::get("tnlib.app_version.store_urls.ios");
                return $baseUrl . $appId;

            case "android":
                $packageId = Config::get("tnlib.app_version.android_package_id");
                $baseUrl = Config::get("tnlib.app_version.store_urls.android");
                return $baseUrl . $packageId;

            default:
                return "";
        }
    }
}
