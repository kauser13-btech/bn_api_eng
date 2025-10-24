<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Ads;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;

use Carbon\Carbon;
use App\Models\News;

use App\Jobs\SingleNewsCache;

class MakeDetailCache extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:detailcache';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';




    public function handle()
    {

        $time1 = time();
        $date = Carbon::now()->subDays(10);

        News::where('created_at', '>=', $date)->orderBy('n_id', 'desc')->chunk(10, function ($colectedNews) {
            foreach ($colectedNews as $snews) {
                if (!Cache::get('details-' . $snews->n_id)) {
                    // \Log::info('Id ' . $snews->n_id);
                    dispatch(new SingleNewsCache($snews->n_id));
                }
            }
        });


        $time2 = time();
        $seconds_diff =  $time2 -  $time1;
        \Log::info('Time ' . $seconds_diff);
        return Command::SUCCESS;
    }
}
