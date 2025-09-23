<?php

namespace Tnlake\Lib;

use Illuminate\Support\ServiceProvider;
use Tnlake\Lib\AppVersion\Services\AppVersionService;
use Tnlake\Lib\AppVersion\Commands\UpdateStoreVersionCache;

class LibServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // パッケージ内のデフォルト設定を取り込む（アプリ側で上書き可）
        $this->mergeConfigFrom(__DIR__ . "/../config/tnlib.php", "tnlib");

        // AppVersionServiceをシングルトンとして登録
        $this->app->singleton(AppVersionService::class);
    }

    public function boot(): void
    {
        // アプリ側に設定ファイルを publish できるようにする
        $this->publishes(
            [
                __DIR__ . "/../config/tnlib.php" => $this->app->configPath("tnlib.php")
            ],
            "tnlib-config"
        );

        // コマンドを登録
        if ($this->app->runningInConsole()) {
            $this->commands([UpdateStoreVersionCache::class]);
        }
    }
}
