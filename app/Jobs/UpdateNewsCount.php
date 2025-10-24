<?php

namespace App\Jobs;

use App\Models\News;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpdateNewsCount implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $nid;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($n_id)
    {
        $this->nid = $n_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(News $news)
    {
         News::findNewsTable($this->nid)->where('n_id',$this->nid)->increment('most_read', 1);
    }
}
