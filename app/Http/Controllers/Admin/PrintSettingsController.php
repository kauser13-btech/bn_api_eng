<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
// use Illuminate\Http\Request;

use Auth;
use Session;
use Redirect;
use App\Models\News;
use App\Models\Astrology;
use App\Models\PrintSettings;
use App\Models\Emagazine;
use App\Helpers\clearCacheHelpers;
use App\Http\Requests\PrintSettingsRequest;

class PrintSettingsController extends Controller
{

    public function epaperdate()
    {
        $name = 'Set E-Paper & Print New Date';
        $btn = 'Add';
        $actionName = 'E-Paper-New-Date';
        $sqlRow = PrintSettings::with(['createdBy', 'updatedBy'])->where('type', $actionName)->orderBy('id', 'desc')->paginate(15);
        return view('admin.printsettings.index', compact('name', 'btn', 'actionName', 'sqlRow'));
    }

    public function printpublish()
    {
        $name = 'Publish Print New Date';
        $btn = 'Publish';
        $actionName = 'Publish-Print-New-Date';
        $sqlRow = PrintSettings::with(['createdBy', 'updatedBy'])->where('type', $actionName)->orderBy('id', 'desc')->paginate(15);
        return view('admin.printsettings.index', compact('name', 'btn', 'actionName', 'sqlRow'));
    }

    public function epaperpublish()
    {
        $name = 'E-Paper Publish';
        $btn = 'Publish';
        $actionName = 'Publish-E-Paper-New-Date';
        $sqlRow = PrintSettings::with(['createdBy', 'updatedBy'])->where('type', $actionName)->orderBy('id', 'desc')->paginate(15);
        return view('admin.printsettings.index', compact('name', 'btn', 'actionName', 'sqlRow'));
    }

    public function magazinedate()
    {
        $name = 'Set Magazine New Date';
        $btn = 'Add';
        $actionName = 'Magazine-New-Date';
        $sqlRow = PrintSettings::with(['createdBy', 'updatedBy'])->where('type', $actionName)->orderBy('id', 'desc')->paginate(15);
        return view('admin.printsettings.index', compact('name', 'btn', 'actionName', 'sqlRow'));
    }

    public function magazinepublish()
    {
        $name = 'Publish Magazine New Date';
        $btn = 'Publish';
        $actionName = 'Publish-Magazine-New-Date';
        $sqlRow = PrintSettings::with(['createdBy', 'updatedBy'])->where('type', $actionName)->orderBy('id', 'desc')->paginate(15);
        return view('admin.printsettings.index', compact('name', 'btn', 'actionName', 'sqlRow'));
    }

    public function emagazinepublish()
    {
        $name = 'E-Magazine Publish';
        $btn = 'Publish';
        $actionName = 'Publish-E-Magazine-New-Date';
        $sqlRow = PrintSettings::with(['createdBy', 'updatedBy'])->where('type', $actionName)->orderBy('id', 'desc')->paginate(15);
        return view('admin.printsettings.index', compact('name', 'btn', 'actionName', 'sqlRow'));
    }

    public function epublishhandler(PrintSettingsRequest $request, clearCacheHelpers $clearCacheHelpers)
    {
        PrintSettings::create([
            'type' => $request->input('actionName'),
            'pdate' => $request->input('e-date'),
            'created_by' => Auth::user()->id,
        ]);

        /*
            * E-Paper-New-Date -> get print and epaper news date
            * Publish-Print-New-Date -> publish print news
            * Publish-E-Paper-New-Date -> publish e-paper
            * Magazine-New-Date -> get magazine and e-magazine news date
            * Publish-Magazine-New-Date -> publish magazine news
            * Publish-E-Magazine-New-Date -> publish e magazine
        */

        switch ($request->input('actionName')) {
            case 'E-Paper-New-Date':
                $mess = "Add E-Paper New Date";
                $clearCacheHelpers->eCacheHandler('E-Paper-New-Date', $request->input('e-date'));
                break;
            case 'Publish-Print-New-Date':
                News::where('edition', 'print')->where('n_status', 2)->where('start_at', $request->input('e-date'))->update([
                    'n_status' => 3
                ]);
                Astrology::where('p_status', 2)->where('start_date', $request->input('e-date'))->update([
                    'p_status' => 1
                ]);
                $mess = "Publish Print";
                $clearCacheHelpers->eCacheHandler('Publish-Print-New-Date', $request->input('e-date'));
                break;
            case 'Publish-E-Paper-New-Date':
                $mess = "Publish E-Paper";
                $clearCacheHelpers->eCacheHandler('Publish-E-Paper-New-Date', $request->input('e-date'));
                break;
            case 'Magazine-New-Date':
                $mess = "Add Magazine New Date";
                break;
            case 'Publish-Magazine-New-Date':
                News::where('edition', 'magazine')->where('n_status', 2)->where('start_at', $request->input('e-date'))->update([
                    'n_status' => 3
                ]);
                $mess = "Publish Magazine";
                $clearCacheHelpers->eCacheHandler('Publish-Magazine-New-Date', $request->input('e-date'));
                break;
            case 'Publish-E-Magazine-New-Date':
                Emagazine::where('status', 1)->where('p_date', $request->input('e-date'))->update([
                    'status' => 3
                ]);
                $mess = "Publish E-Magazine";
                $clearCacheHelpers->eCacheHandler('Publish-E-Magazine-New-Date', $request->input('e-date'));
                break;
            default:
                break;
        }

        Session::flash('success', "Successfully " . $mess);
        return Redirect::back();
    }
}
