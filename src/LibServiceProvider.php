<?php

namespace Tnlake\Lib;

use Illuminate\Support\ServiceProvider;

class LibServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // パッケージ内のデフォルト設定を取り込む（アプリ側で上書き可）
        $this->mergeConfigFrom(__DIR__ . "/../config/tn-lib.php", "tn-lib");
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
