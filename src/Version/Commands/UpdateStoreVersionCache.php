<?php

namespace Tnlake\Lib\Version\Commands;

use Tnlake\Lib\Version\Services\AppVersionService;
use Illuminate\Console\Command;

class UpdateStoreVersionCache extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = "tnlib:update-store-version-cache";

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Update app version cache from App Store";

    /**
     * Execute the console command.
     */
    public function handle(AppVersionService $versionService): int
    {
        $this->info("Updating iOS app version cache...");

        try {
            $versionInfo = $versionService->refreshVersions();

            if ($versionInfo && isset($versionInfo["version"])) {
                $this->info("iOS version cache updated successfully:");
                $this->line("  Version: {$versionInfo["version"]}");
                if (isset($versionInfo["release_date"])) {
                    $this->line("  Release Date: {$versionInfo["release_date"]}");
                }
            } else {
                $this->warn("Unable to fetch iOS version from App Store");
            }

            return Command::SUCCESS;
        } catch (\Exception $e) {
            $this->error("Failed to update version cache: " . $e->getMessage());
            return Command::FAILURE;
        }
    }
}
