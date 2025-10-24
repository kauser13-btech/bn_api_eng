<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;


use App\Models\Ads;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;

use Carbon\Carbon;
use App\Models\News;
use App\Models\Paper;
use App\Models\Gallery;
use App\Models\LinkBetweenNews;
use Jenssegers\Agent\Agent;
use App\Models\BreakingNews;
use App\Helpers\generalHelper;
use App\Helpers\ImageStoreHelpers;

class SingleNewsCache implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $n_id;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($n_id)
    {
        $this->n_id = $n_id;
    }


    private function cacheNews($n_id)
    {
        try {
            $sql = News::findNewsTable($n_id)->with(['catName', 'getWriters'])->isActive()->find($n_id);
            if ($sql) {
                $sql->n_solder = strip_tags(html_entity_decode($sql->n_solder));
                $sql->n_head = strip_tags(html_entity_decode($sql->n_head));
                $sql->n_subhead = strip_tags(html_entity_decode($sql->n_subhead));
                $sql->n_details = str_replace('/ckfinder/innerfiles/', 'https://asset.banglanews24.com/public/news_images/ckfinder/innerfiles/', htmlentities(html_entity_decode($sql->n_details)));
                $ifOg = ($sql->watermark != '') ? 'og' : '';
                $sql->openGraphImg = ImageStoreHelpers::showImage('news_images', $sql->created_at, $sql->main_image, $ifOg);
                $sql->datePublished = date('h:i A, F Y, l', strtotime($sql->start_at));
                $sql->dateModified = date('h:i A, F Y, l', strtotime(($sql->edit_at) ? $sql->edit_at : $sql->start_at));
                $sql->date_at = generalHelper::bn_date(date("d F, Y H:i", strtotime($sql->start_at)));
                $sql->edit_at = $sql->edit_at ? generalHelper::bn_date(date("l, d F, Y H:i", strtotime($sql->edit_at))) : '';
                $sql->main_image = ImageStoreHelpers::showImage('news_images', $sql->created_at, $sql->main_image, '');
                $sql->meta_description = $sql->meta_description ? strip_tags(html_entity_decode($sql->meta_description)) : generalHelper::splitText(strip_tags(html_entity_decode($sql->n_details)), 400);

                $sql->writers_img = ($sql->getWriters) ? ImageStoreHelpers::showImage('profile', $sql->getWriters->created_at, $sql->getWriters->img) : '';
                $sql->writers_name = ($sql->getWriters) ? $sql->getWriters->name : '';
                $sql->f_date = date("Y/m/d", strtotime($sql->start_at));
                Cache::put('details-' . $n_id, $sql);

                return $sql;
            }
        } catch (Exception $e) {
            // \Log::info("NID = {$n_id}=== {$e->getMessage()}");
        }
    }


    private function cacheTags($n_id, $tag_id)
    {
        try {
            $sql = News::select('n_id', 'n_head', 'n_category', 'edition', 'main_image', 'start_at', 'created_at', 'deleted_at')->isActive()->with('newsTag')->where('news_tags', $tag_id)->where('n_id', '!=', $n_id)->limit(29)->orderBy('start_at', 'desc')->get();

            $sql->transform(function ($row, $key) {
                $row->f_date = date("Y/m/d", strtotime($row->start_at));
                return $row;
            });
            Cache::put('news_tags-' . $tag_id, $sql);
        } catch (Exception $e) {
            // \Log::info("NID = {$n_id}=== {$e->getMessage()}");
        }
    }


    private function cacheKeywords($n_id, $details)
    {
        try {

            if ($details->meta_keyword != '') {
                $keyword = explode(',', $details->meta_keyword);
                $sql = News::select('n_id', 'n_head', 'n_category', 'edition', 'main_image', 'start_at', 'created_at', 'deleted_at')->isActive()->with('catName')
                    ->Where(function ($query) use ($keyword) {
                        for ($i = 0; $i < count($keyword); $i++) {
                            $query->orwhere('meta_keyword', 'like', '%' . trim($keyword[$i]) . '%');
                        }
                    })
                    ->where('n_id', '!=', $n_id)->orderBy('most_read', 'desc')->limit(4)->get();

                $sql->transform(function ($row, $key) {
                    $row->main_image = ImageStoreHelpers::showImage('news_images', $row->created_at, $row->main_image, 'thumbnail');
                    $row->date_at = generalHelper::time_elapsed_string($row->start_at);
                    $row->f_date = date("Y/m/d", strtotime($row->start_at));
                    return $row;
                });
            }

            Cache::put($details->meta_keyword . '-meta_keyword', $sql);
        } catch (Exception $e) {
            // \Log::info("NID = {$n_id}=== {$e->getMessage()}");
        }
    }


    private function makeCategoryCache($n_id, $details)
    {
        try {

            $cat = $details->n_category;
            $sql = News::with(['catName', 'getWriters'])->isActive()->where('n_category', $cat)->where('n_id', '!=', $n_id)->orderBy('n_id', 'desc')->limit(4)->get();
            $sql->transform(function ($row, $key) {
                $row->main_image = ImageStoreHelpers::showImage('news_images', $row->created_at, $row->main_image, 'thumbnail');
                $row->n_solder = strip_tags(html_entity_decode($row->n_solder));
                $row->n_head = strip_tags(html_entity_decode($row->n_head));
                $row->n_subhead = strip_tags(html_entity_decode($row->n_subhead));
                $row->n_details = str_replace('/ckfinder/innerfiles/', 'https://asset.banglanews24.com/public/news_images/ckfinder/innerfiles/', htmlentities(html_entity_decode($row->n_details)));
                $row->date_at = generalHelper::bn_date(date("l, d F, Y H:i", strtotime($row->start_at)));
                $row->edit_at = $row->edit_at ? generalHelper::bn_date(date("l, d F, Y H:i", strtotime($row->edit_at))) : '';
                $row->writers_img = ($row->getWriters) ? ImageStoreHelpers::showImage('profile', $row->getWriters->created_at, $row->getWriters->img) : '';
                $row->writers_name = ($row->getWriters) ? $row->getWriters->name : '';
                $row->f_date = date("Y/m/d", strtotime($row->start_at));

                return $row;
            });

            Cache::put($cat . '-' . $n_id . '-more', $sql);
        } catch (Exception $e) {
            // \Log::info("NID = {$n_id}=== {$e->getMessage()}");
        }
    }

    private function makeDetailCache($n_id)
    {
        try {


            $details = $this->cacheNews($n_id);

            if ($details) {
                if ($details->news_tags != '') {
                    $this->cacheTags($n_id, $details->news_tags);
                }
            }

            if ($details) {
                if ($details->meta_keyword != '') {
                    $this->cacheKeywords($n_id, $details);
                }
            }


            if ($details) {
                if ($details->meta_keyword != '') {
                    $this->makeCategoryCache($n_id, $details);
                }
            }






            \Log::info("Detail Cache Done====" . $n_id);
        } catch (Exception $e) {
            \Log::info("NID = {$n_id}=== {$e->getMessage()}");
        }
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->makeDetailCache($this->n_id);
    }
}
