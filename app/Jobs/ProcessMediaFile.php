<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessMediaFile implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(protected Model $model, protected string $field, protected $mediaItem)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $this->model->addMedia($this->mediaItem->getPath())
            ->preservingOriginal()
            ->toMediaCollection($this->field);
    }
}
