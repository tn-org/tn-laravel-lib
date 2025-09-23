<?php

return [
    "version" => [
        "min_versions" => [
            "ios" => "0.0.1",
            "android" => "0.0.1"
        ],

        /**
         * App Store IDs
         */
        "ios_app_id" => env("IOS_APP_ID", ""),
        "android_package_id" => env("ANDROID_PACKAGE_ID", ""),

        /**
         * キャッシュ設定
         */
        "cache_key" => "tn_lib_app_store_versions",

        /**
         * ストアURL
         */
        "store_urls" => [
            "ios" => "https://apps.apple.com/app/id",
            "android" => "https://play.google.com/store/apps/details?id="
        ],

        /**
         * iTunes Lookup API設定
         */
        "itunes_lookup_url" => "https://itunes.apple.com/lookup",
        "itunes_country" => "jp"
    ]
];
