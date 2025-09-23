<?php

namespace Tnlake\Lib\Version\Services;

use Tnlake\Lib\Version\Contracts\VersionChecker;

final class VersionCheckerImpl implements VersionChecker
{
    public function __construct(private array $minVersions) {}

    public function minSupported(): array
    {
        return $this->minVersions;
    }

    public function isSupported(string $platform, string $version): bool
    {
        $min = $this->minVersions[$platform] ?? null;
        if ($min === null) {
            return false; // 未知プラットフォームは非対応扱い
        }
        return version_compare($version, $min, ">=");
    }
}
