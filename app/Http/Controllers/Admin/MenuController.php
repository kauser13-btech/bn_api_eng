<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
// use Illuminate\Http\Request;
use App\Http\Requests\MenuRequest;
use App\Helpers\clearCacheHelpers;

use Auth;
use Session;
use Redirect;
use App\Models\Menu;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Menus = Menu::with(['parentName','createdBy','updatedBy']);

        if (Auth::user()->type != 'online' && Auth::user()->type != 'all') {
            $Menus = $Menus->where('m_edition','!=','online');
        }

        $Menus = $Menus->cursor();
        return view('admin.menu.index', compact('Menus'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.menu.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MenuRequest $request, clearCacheHelpers $clearCacheHelpers)
    {
        $visible = ($request->input('m_visible')=='') ? 0 : 1;
        $status = ($request->input('m_status')=='') ? 0 : 1;
        $m_parent = ($request->input('m_parent')=='') ? 0 : $request->input('m_parent');

        Menu::create([
            'm_name' => $request->input('m_name'),
            'slug' => $request->input('slug'),
            'm_edition' => $request->input('m_edition'),
            'm_title' => $request->input('m_title'),
            'm_keywords' => $request->input('m_keywords'),
            'm_desc' => $request->input('m_desc'),
            'm_parent' => $m_parent,
            'm_order' => $request->input('m_order'),
            'm_status' => $status,
            'm_visible' => $visible,
            's_news' => $request->input('s_news'),
            'm_color' => $request->input('m_color'),
            'm_bg' => $request->input('m_bg'),
            'created_by' => Auth::user()->id,
        ]);
        $clearCacheHelpers->menuClear();
        Session::flash('success', "Successfully Inserted");
        return Redirect::back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        echo 'show';
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $Menu = Menu::find($id);
        $ParentName = Menu::select('m_id','m_name')->find($Menu->m_parent);
        return view('admin.menu.edit', compact('Menu','ParentName'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(MenuRequest $request, $id, clearCacheHelpers $clearCacheHelpers)
    {
        $visible = ($request->input('m_visible')=='') ? 0 : 1;
        $status = ($request->input('m_status')=='') ? 0 : 1;

        Menu::where('m_id', $id)->update([
            'm_name' => $request->input('m_name'),
            'slug' => $request->input('slug'),
            'm_edition' => $request->input('m_edition'),
            'm_title' => $request->input('m_title'),
            'm_keywords' => $request->input('m_keywords'),
            'm_desc' => $request->input('m_desc'),
            'm_parent' => $request->input('m_parent'),
            'm_order' => $request->input('m_order'),
            'm_status' => $status,
            'm_visible' => $visible,
            's_news' => $request->input('s_news'),
            'm_color' => $request->input('m_color'),
            'm_bg' => $request->input('m_bg'),
            'updated_by' => Auth::user()->id,
        ]);

        $clearCacheHelpers->menuClear();

        Session::flash('success', "Successfully Updated");
        return Redirect::back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, MenuRequest $request)
    {
        Menu::where('m_id', $id)->update([
            'deleted_by' => Auth::user()->id,
            'deleted_at' => date('Y-m-d H:i:s'),
        ]);
        Session::flash('success', "Successfully Deleted");
        return Redirect::back();
    }

    /**
     * Api Find Desktop or Mobile Position 
     *
     * @param   $version, $page
     */
    public function apiFindParentMenu($edition, $mid, $txt='')
    {
        $results[] = [];

        $sql = Menu::select('m_id','m_name')->where('m_parent',0)->where('m_status',1)->where('m_edition',$edition);

        if ($txt!='' && $txt != 'undefined') {
            $sql = $sql->where('m_name', 'like', $txt.'%');
        }else {
            $results[] = [
                "id"=> '',
                "text"=> 'None'
            ];
        }
        $sql = $sql->limit(10)->get();

        foreach ($sql as $value) {
            if($mid == $value->m_id){continue;}

            $results[] = [
                "id"=> $value->m_id,
                "text"=> $value->m_name
            ];
        }
        $arr = [
            "results" => $results
        ];

              

        return response()->json($arr);
    }
}
