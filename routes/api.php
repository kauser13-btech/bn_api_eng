<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\TagManager;
use App\Http\Controllers\Admin\AdsController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\AdsPositionController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\PoolController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\Admin\EmagazineController;

use App\Http\Controllers\AppController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DetailsController;
use App\Http\Controllers\myGalleryController;
use App\Http\Controllers\RssFeedController;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\AuthorController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/findparentmenu/{Edition}/{mid}/{txt?}', [MenuController::class, 'apiFindParentMenu']);
Route::get('/findposition/{device}/{page}/{txt?}', [AdsPositionController::class, 'apiFindPosition']);
Route::get('/findgallerycat/{type}', [GalleryController::class, 'apiFindGalleryCat']);
Route::get('/findads/{sd}/{ed}/{txt?}', [ReportController::class, 'apiFindads']);

Route::get('/findtags/{txt?}', [TagManager::class, 'apiFindTags']);
Route::post('/timeline', [DetailsController::class, 'timeline']);
Route::get('/findwatermarkads/{txt?}', [NewsController::class, 'findwatermarkads']);
Route::get('/findmorenews/{txt}', [NewsController::class, 'findMoreNews']);
Route::get('/topNewsCallback', [NewsController::class, 'topNewsCallback']);
Route::get('/findemagazinecat/{txt?}', [EmagazineController::class, 'apiFindMagazineCat']);
Route::post('/embedSocial', [NewsController::class, 'embedSocial']);

// web
Route::get('/web_home', [HomeController::class, 'index'])->name('webhome');
Route::get('/web_home2', [HomeController::class, 'index2'])->name('webhome2');
Route::get('/web_allnavs', [HomeController::class, 'webnavs'])->name('webnavs');
Route::get('/web_todaysdate', [HomeController::class, 'todayDate'])->name('webtodaydate');
Route::get('/web_details/{n_id}', [DetailsController::class, 'index'])->name('webdetails');
Route::get('/web_homevideogallery', [HomeController::class, 'homeVideoGallery'])->name('webhomeVideoGallery');
Route::get('/web_homephotogallery', [HomeController::class, 'homePhotoGallery'])->name('webhomePhotoGallery');
Route::get('/web_specialTagNews', [HomeController::class, 'specialTagNews'])->name('webspecialTagNews');

Route::post('/web_most_view', [myGalleryController::class, 'most_view'])->name('webmostview');
Route::get('/web_photogallery', [myGalleryController::class, 'photo_gallery'])->name('webphotogallery');
Route::get('/web_photoviewer/{id}', [myGalleryController::class, 'photo_viewer'])->name('webphotoviewer');

Route::get('/web_videogallery', [myGalleryController::class, 'video_gallery'])->name('webvideogallery');
Route::get('/gallery_cat/{catid}', [myGalleryController::class, 'gallery_cat'])->name('webvideogallery');
Route::get('/web_videoviewer/{id}', [myGalleryController::class, 'video_viewer'])->name('webvideogallery');
// Route::get('/web_pools', [HomeController::class, 'pools'])->name('webpools');
// Route::get('/web_multimediahome', [HomeController::class, 'multimedia'])->name('webmultimedia');

// Route::get('/web_multimediaDetails/{n_id}', [DetailsController::class, 'multimediaDetails'])->name('webmultimediaDetails');

Route::get('/web_archive/{rqsdate?}', [HomeController::class, 'archive'])->name('archive');
Route::post('/web_hit_details', [DetailsController::class, 'hit'])->name('hit');
// Route::get('/top10_news', [HomeController::class, 'top10News'])->name('newTop10News');
// Route::get('/todays_quiz', [HomeController::class, 'todaysQuiz'])->name('todaysQuiz');
// Route::post('/quiz/add', [HomeController::class, 'quizAdd'])->name('quizAdd');
Route::get('/stockMarquee', [HomeController::class, 'stockMarquee'])->name('stockMarquee');

Route::get('/web_tagNews/{tag}', [HomeController::class, 'tagNews'])->name('tagNews');

Route::get('/election', [CategoryController::class, 'election'])->name('online-election');

Route::get('/todayall', [CategoryController::class, 'todayall'])->name('todayall');
Route::get('/online/{cat}', [CategoryController::class, 'index'])->name('online-category');
// Route::get('/printversion/today-all', [CategoryController::class, 'printhome'])->name('printhome');
Route::get('/print-edition/{cat}/{pdate?}', [CategoryController::class, 'index'])->name('printversion-category');
Route::get('/feature/{cat}', [CategoryController::class, 'index'])->name('magazine-category');
Route::get('/web_geo/{divisions?}/{districts?}/{upazilas?}', [CategoryController::class, 'geo'])->name('webgeo');
Route::get('/topic/{keyword}', [CategoryController::class, 'topic'])->name('topic');
Route::get('/multimedia/{cat}', [CategoryController::class, 'multimediaCat'])->name('multimedia-category');

Route::post('/pool/update', [PoolController::class, 'voteUpdate'])->name('voteUpdate');


Route::get('/tst/feature/{cat}', [CategoryController::class, 'testoldCategory'])->name('feature-testoldCategory');


Route::get('/countdown', [HomeController::class, 'countDown'])->name('countDown');

// author
Route::get('/web_author/{aid}', [AuthorController::class, 'index'])->name('index');

// rss
Route::get('/daily-sitemap/sitemap-section', [RssFeedController::class, 'sitemap_section'])->name('sitemap_section');
Route::get('/daily-sitemap/{date}/sitemap', [RssFeedController::class, 'daily_sitemap'])->name('daily_sitemap');
Route::get('/fb-instant', [RssFeedController::class, 'fb_rss'])->name('fb_rss');
Route::get('/recent-rss', [RssFeedController::class, 'recent_rss'])->name('recent_rss');

// app
Route::get('/home', [AppController::class, 'home']);
Route::get('/menu_list', [AppController::class, 'menu_list']);
Route::get('/categorynews/{m_id}', [AppController::class, 'categorynews']);
Route::get('/categoryvideos/{m_id}', [AppController::class, 'categoryvideos']);
Route::get('/news_details/{n_id}', [AppController::class, 'details']);


Route::prefix('front')->group(function () {
    Route::get('/web-home-lead', [FrontController::class, 'homeLead'])->name('webhomelead');
    Route::get('/web-home-latest', [FrontController::class, 'homeLatest'])->name('webhomelatest');
    Route::get('/web-home-most-read', [FrontController::class, 'homeMostRead'])->name('webhomemostread');
    Route::get('/web-home-multimedia', [FrontController::class, 'homeMultimedia'])->name('webhomemultimedia');
    Route::get('/web-home-gallery', [FrontController::class, 'homeGallery'])->name('webhomegallery');
    Route::get('/web-home-cat/{cat_id}', [FrontController::class, 'homeCatNews'])->name('webhomecatnews');
});
