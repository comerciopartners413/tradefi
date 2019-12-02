<?php

namespace TradefiUBA\Http\Controllers;

// use TradefiUBA\Events\MenuWasCreated;
// use TradefiUBA\Events\MenuWasDeleted;
// use TradefiUBA\Events\MenuWasUpdated;
use TradefiUBA\Http\Requests\MenuRequest;
use TradefiUBA\menu;
use Event;
use Illuminate\Http\Request;

class MenuController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $menus = Menu::all();

        return $menus;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $menus           = Menu::all();
        $routeCollection = \Route::getRoutes();
        $routeArray      = array();

        foreach ($routeCollection as $key => $value) {
            array_push($routeArray, $value->getName());
        }
        $routes = array_filter($routeArray, function ($var) {return !is_null($var);});
        // dd($activity->get());
        return view('menus.create', compact('menus', 'routes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MenuRequest $request)
    {
        $menu = Menu::create(request()->all());
        if ($menu) {
            // Event::fire(new MenuWasCreated($menu));
            return redirect('menus/create')->with('success', 'Menu Added successfully');
        } else {
            return redirect('menus/create')->withInput()->with('error', 'Menu not created, make sure all fields are filled');
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $menu            = Menu::find($id);
        $menus           = Menu::all();
        $routeCollection = \Route::getRoutes();
        $routeArray      = array();

        foreach ($routeCollection as $key => $value) {
            array_push($routeArray, $value->getName());
        }
        $routes = array_filter($routeArray, function ($var) {return !is_null($var);});
        return view('menus.edit', compact('menu', 'menus', 'routes'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $menu = Menu::find($id);
        if ($request->ajax()) {
            $menu->update($request->except(['action']));
            return response('see');
        }
        if ($menu->update($request->all())) {
            // Event::fire(new MenuWasUpdated($menu));

            return redirect('menus/create')->with('success', 'Menu has been updated successfully');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $menu = Menu::find($id);
        if ($menu) {

            if (\DB::table('menus')->where('id', $id)->delete()) {
                // Event::fire(new MenuWasDeleted($menu));
                return redirect('menus/create')->with('success', 'Menu was deleted successfully');
            } else {
                return redirect('menus/create')->with('danger', 'Menu was not deleted');
            }

        }

    }
}
