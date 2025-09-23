<?php

namespace Tnlake\Lib;

use Illuminate\Support\ServiceProvider;
use Tnlake\Lib\Version\Contracts\VersionChecker;
use Tnlake\Lib\Version\Services\VersionCheckerImpl;

class LibServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // パッケージ内のデフォルト設定を取り込む（アプリ側で上書き可）
        $this->mergeConfigFrom(__DIR__ . "/../config/tn-lib.php", "tn-lib");

        $this->app->singleton(VersionChecker::class, function ($app) {
            $min = $app["config"]->get("tn-lib.min_versions", []);
            return new VersionCheckerImpl($min);
        });
    }

    public function boot(): void
    {
        // アプリ側に設定ファイルを publish できるようにする
        $this->publishes(
            [
                __DIR__ . "/../config/tn-lib.php" => $this->app->configPath("tn-lib.php")
            ],
            "tn-lib-config"
        );
    }
}
