<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeploymentLog extends Model
{
    public $table = 'deployment_logs';

    protected $fillable = ['commit_hash', 'deployed_by', 'changed_files', 'migrations'];

    protected $casts = [
        'changed_files' => 'array',
        'migrations' => 'array',
    ];

    protected $test = 'testt';
}
