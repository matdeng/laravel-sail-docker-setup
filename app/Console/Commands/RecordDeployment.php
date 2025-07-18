<?php

namespace App\Console\Commands;

use App\Models\DeploymentLog;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;
class RecordDeployment extends Command
{
    protected $signature = 'deploy:record {--user=}';
    protected $description = 'Record deployment details for audit and recovery';

    public function handle()
    {
        // Get latest commit hash
        $commit = trim(shell_exec('git rev-parse HEAD'));

         Artisan::call('migrate', ['--force' => true]);
        $output = Artisan::output();

        // Extract migration names from output
        preg_match_all('/Migrating:\s+(\d{4}_\d{2}_\d{2}_\d{6}_[^\s]+)/', $output, $matches);
        $migrations = $matches[1] ?? [];

        // Get changed files in this commit
        $files = explode("\n", trim(shell_exec("git diff-tree --no-commit-id --name-only -r $commit")));
        if (count($files) === 1 && $files[0] === "") {
            $files = []; // Fix empty array edge case
        }

        // Get user
        $user = $this->option('user') ?? get_current_user();

        if (DeploymentLog::where('commit_hash', $commit)->exists()) {
            $this->warn("Commit $commit already recorded. Skipping.");
            return Command::SUCCESS;
        }
        // Save to database
        DeploymentLog::create([
            'commit_hash'    => $commit,
            'deployed_by'    => $user,
            'changed_files'  => $files,
            'migrations'     => !empty($migrations) ? $migrations : null,
        ]);

        $this->info("Deployment recorded for commit: $commit");
    }
}
