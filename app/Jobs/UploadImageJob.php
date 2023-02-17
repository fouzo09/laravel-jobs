<?php

namespace App\Jobs;

use App\Models\User;
use App\Services\ImageService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UploadImageJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $imageNames;
    protected $folderName;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($imageNames, $folderName)
    {
        $this->imageNames = $imageNames;
        $this->folderName = $folderName;       
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        ImageService::resizeFromFolder($this->imageNames, $this->folderName);
    }
}
