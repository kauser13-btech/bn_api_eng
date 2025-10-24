<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\AdsController;
use App\Http\Controllers\Admin\AdsPositionController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\Admin\PoolController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\PrintSettingsController;
use App\Http\Controllers\Admin\BreakingNewsController;
use App\Http\Controllers\Admin\ScreenController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\WritersController;
use App\Http\Controllers\Admin\TagManager;
use App\Http\Controllers\Admin\AstrologyController;
use App\Http\Controllers\Admin\MiscellaneousController;
use App\Http\Controllers\Admin\EmagazineController;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DetailsController;
use App\Http\Controllers\RssFeedController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware(['auth', 'verified'])->prefix('admin')->group(function () {
	Route::get('/error403', [DashboardController::class, 'error403']);
	Route::get('/dashboard', [DashboardController::class, 'index']);
	Route::get('/profile', [DashboardController::class, 'profile']);
	Route::post('/profileUpdate', [DashboardController::class, 'profileUpdate']);

	Route::get('/news/{nid}/release', [NewsController::class, 'release'])->name('news.release');
	Route::get('/news/sorting', [NewsController::class, 'sorting'])->name('news.sorting');
	Route::get('/news/sortnews/{mid}', [NewsController::class, 'sortnews'])->name('news.sortnews');
	Route::post('/news/sortupdate', [NewsController::class, 'sortupdate'])->name('news.sortupdate');
	Route::get('/news/trash', [NewsController::class, 'trash'])->name('news.trash');
	Route::post('/news/restore', [NewsController::class, 'restore'])->name('news.restore');
	Route::get('/news/livenews', [NewsController::class, 'livenews'])->name('news.live');
	Route::get('/news/livenewslist/{nid}', [NewsController::class, 'livenewslist'])->name('news.livenewslist');

	Route::get('/gallery/sort/{type}', [GalleryController::class, 'sort'])->name('gallery.sort');
	Route::post('/gallery/sortupdate', [GalleryController::class, 'sortupdate'])->name('gallery.sortupdate');
	Route::get('/gallery/category', [GalleryController::class, 'category'])->name('gallery.category');
	Route::post('/gallery/categorystore', [GalleryController::class, 'categorystore'])->name('gallery.categorystore');
	Route::get('/gallery/category/{id}/edit', [GalleryController::class, 'categoryEdit'])->name('gallery.categoryEdit');
	Route::post('/gallery/category/categoryupdate', [GalleryController::class, 'categoryupdate'])->name('gallery.categoryupdate');
	Route::post('/gallery/category/destroy', [GalleryController::class, 'categorydestroy'])->name('gallery.categorydestroy');

	Route::resources([
		'menu' => MenuController::class,
		'ads' => AdsController::class,
		'adsposition' => AdsPositionController::class,
		'user' => UserController::class,
		'news' => NewsController::class,
		'pool' => PoolController::class,
		'gallery' => GalleryController::class,
		'breakingnews' => BreakingNewsController::class,
		'screen' => ScreenController::class,
		'writers' => WritersController::class,
		'astrology' => AstrologyController::class,
		'emagazine' => EmagazineController::class,
	]);

	Route::get('/emagazine/cat/add', [EmagazineController::class, 'catAdd'])->name('emagazine.catAdd');
	Route::post('/emagazine/cat/store', [EmagazineController::class, 'catStore'])->name('emagazine.catStore');
	Route::get('/emagazine/cat/{id}/edit', [EmagazineController::class, 'catEdit'])->name('emagazine.catEdit');
	Route::patch('/emagazine/cat/update', [EmagazineController::class, 'catUpdate'])->name('emagazine.catUpdate');

	Route::get('/printsettings/epaperdate', [PrintSettingsController::class, 'epaperdate'])->name('printsettings.epaperdate');
	Route::get('/printsettings/printpublish', [PrintSettingsController::class, 'printpublish'])->name('printsettings.printpublish');
	Route::get('/printsettings/epaperpublish', [PrintSettingsController::class, 'epaperpublish'])->name('printsettings.epaperpublish');
	Route::get('/printsettings/magazinedate', [PrintSettingsController::class, 'magazinedate'])->name('printsettings.magazinedate');
	Route::get('/printsettings/magazinepublish', [PrintSettingsController::class, 'magazinepublish'])->name('printsettings.magazinepublish');
	Route::get('/printsettings/emagazinepublish', [PrintSettingsController::class, 'emagazinepublish'])->name('printsettings.emagazinepublish');
	
	Route::post('/printsettings/epublishhandler', [PrintSettingsController::class, 'epublishhandler'])->name('printsettings.epublishhandler');

	Route::get('/report/daily-title-report/', [ReportController::class, 'dailyTitleReport']);
	Route::get('/report/daily-news-report/', [ReportController::class, 'dailyNewsReport']);
	Route::get('/report/monthly-news-report/', [ReportController::class, 'monthlyNewsReport']);
	Route::get('/report/cat-news-report/', [ReportController::class, 'catReport']);
	Route::get('/report/watermark-ad/', [ReportController::class, 'watermarkAd']);
	Route::get('/report/special-tag/', [ReportController::class, 'specialTag']);

	Route::get('/tag/', [TagManager::class, 'index']);
	Route::post('/tag/store', [TagManager::class, 'store']);
	Route::post('/tag/update/{id}', [TagManager::class, 'update']);

	Route::get('/electionResult', [MiscellaneousController::class, 'electionResult'])->name('news.electionResult');
	Route::get('/watermark-ad', [MiscellaneousController::class, 'watermarkAd'])->name('dashboard.watermarkAd');
	Route::post('/miscellaneousUpdate', [MiscellaneousController::class, 'miscellaneousUpdate'])->name('miscellaneous.update');
	Route::get('/special-sigment', [MiscellaneousController::class, 'specialSigment'])->name('dashboard.specialSigment');
	Route::post('/miscellaneousSigmentUpdate', [MiscellaneousController::class, 'miscellaneousSigmentUpdate'])->name('miscellaneous.sigment.update');

	Route::get('/newsCard/{n_id}/{ad_id}/{card_id}/{n_solder}', [MiscellaneousController::class, 'newsCard'])->name('miscellaneous.newsCard');

	Route::group(['prefix' => 'news-filemanager', 'middleware' => ['web']], function () {
	    \UniSharp\LaravelFilemanager\Lfm::routes();
	});

});

Route::get('/', function() {
    // dd('Hello You!');
    return view('home');
});
// Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/search', [HomeController::class, 'search'])->name('search');
Route::get('/archive/{arcDate}', [HomeController::class, 'archive'])->name('archive');

Route::get('/online/today-all', [CategoryController::class, 'todayall'])->name('todayall');
Route::get('/online/{cat}', [CategoryController::class, 'index'])->name('online-category');
Route::get('/printversion/today-all', [CategoryController::class, 'printhome'])->name('printhome');
Route::get('/printversion/{cat}', [CategoryController::class, 'index'])->name('printversion-category');

Route::post('/pool/update', [PoolController::class, 'voteUpdate'])->name('voteUpdate');
Route::get('/poll-results', [CategoryController::class, 'pollResults'])->name('pollResults');

Route::get('/post/{n_id}/{title}', [DetailsController::class, 'index'])->name('online-details');
Route::get('/printversion/details/{n_id}/{title}', [DetailsController::class, 'index'])->name('printversion-details');
Route::get('/magazine/details/{n_id}/{title}', [DetailsController::class, 'index'])->name('magazine-details');

Route::get('/epaper/{date}/{page?}', [DetailsController::class, 'epaper'])->name('print-epaper');
Route::post('/epaper/view', [DetailsController::class, 'epaperView'])->name('epaper-view');


Route::post('/details/hit', [DetailsController::class, 'hit'])->name('hit');
Route::get('/ampdetails/{id}', [DetailsController::class, 'ampdetails'])->name('ampdetails');
Route::get('/video-play/{id?}', [DetailsController::class, 'video_play'])->name('video_play');
Route::get('/photo-gallery/{id}', [DetailsController::class, 'photo_gallery'])->name('photo_gallery');
Route::get('/home/printnews/{n_id}', [DetailsController::class, 'printnews'])->name('printnews');
Route::get('/infiniteView/{parentNID}/{infiniteId}', [DetailsController::class, 'infiniteView'])->name('infiniteView');

Route::get('/sitemap.xml', [RssFeedController::class, 'sitemap'])->name('sitemap');
Route::get('/daily-sitemap/sitemap-section.xml', [RssFeedController::class, 'sitemap_section'])->name('sitemap_section');
Route::get('/daily-sitemap/{date}/sitemap.xml', [RssFeedController::class, 'daily_sitemap'])->name('daily_sitemap');
Route::get('/fb-instant.xml', [RssFeedController::class, 'fb_rss'])->name('fb_rss');


Route::get('/appcleanme', function() {
	// Artisan::call('cache:clear');
	// Artisan::call('optimize:clear');
    dd('Cache clear');
});

Route::get('/storagelink', function() {
	// Artisan::call('storage:link');
	dd('storage link');
});


/*
	Old App Api
*/
use App\Http\Controllers\AppController;
Route::get('appapi/homenews', [AppController::class, 'home']);
Route::get('appapi/top_news', [AppController::class, 'top_news']);
Route::get('appapi/menu_list', [AppController::class, 'menu_list']);
Route::get('appapi/categorynews/{m_id}/{p_id?}', [AppController::class, 'categorynews']);
Route::get('/categoryvideos/{m_id}', [AppController::class, 'categoryvideos']);
Route::get('appapi/news_details/{n_id}', [AppController::class, 'old_details']);
Route::get('appapi/my_news/{array}/{p_id?}', [AppController::class, 'my_news']);
Route::get('appapi/news_details_web_view/{n_id}', [AppController::class, 'appDetailsWebView']);



// Route::get('/telescope-clear', function() {
// 	Artisan::call('telescope:clear');
// 	dd('telescope-clear');
// });

// Route::view('dashboard', 'dashboard')
// 	->name('dashboard')
// 	->middleware(['auth', 'verified']);

