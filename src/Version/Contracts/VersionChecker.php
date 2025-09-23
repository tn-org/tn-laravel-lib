<?php

namespace Tnlake\Lib\Version\Contracts;

interface VersionChecker
{
    /** 例: ['ios' => '0.0.1', 'android' => '0.0.1'] */
    public function minSupported(): array;

    /** 指定プラットフォームのバージョンがサポート範囲か（min以上か） */
    public function isSupported(string $platform, string $version): bool;
}
