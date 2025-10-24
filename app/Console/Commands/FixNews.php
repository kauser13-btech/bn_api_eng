<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Models\News;

class FixNews extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fix:news';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
       News::newsTable('2023')->where('edition','print')->orderBy('n_id', 'asc')->chunk(500, function ($colectedNews) {
            foreach ($colectedNews as $snews) {
                $snews->start_at = date("Y-m-d H:i:s", strtotime($snews->n_date));
                $snews->created_at = date("Y-m-d H:i:s", strtotime($snews->n_date));
                $snews->save();
            }
        });
        return Command::SUCCESS;
    }
}
