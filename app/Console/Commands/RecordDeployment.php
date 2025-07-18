<?php

namespace App\Console\Commands;

use App\Models\DeploymentLog;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Process\Process;
class RecordDeployment extends Command
{
    protected $signature = 'deploy:record {--user=}';
    protected $description = 'Record deployment details for audit and recovery';

    public function handle()
    {
        // Get latest commit hash
        $commit = trim(shell_exec('git rev-parse HEAD'));

        // Get changed files
        $files = explode("\n", trim(shell_exec('git diff-tree --no-commit-id --name-only -r ' . $commit)));

        // Get latest migration batch
        $latestBatch = DB::table('migrations')->max('batch');

        $migrations = DB::table('migrations')
            ->where('batch', $latestBatch)
            ->pluck('migration')
            ->toArray();

        // Get user
        $user = $this->option('user') ?? get_current_user();

        if (DeploymentLog::where('commit_hash', $commit)->exists()) {
            $this->warn("Commit $commit already recorded. Skipping.");
            return Command::SUCCESS;
        }
        // Save to database
        DeploymentLog::create([
            'commit_hash' => $commit,
            'deployed_by' => $user,
            'changed_files' => $files,
            'migrations' => $migrations,
        ]);

        $this->info("Deployment recorded for commit: $commit");
    }
}
