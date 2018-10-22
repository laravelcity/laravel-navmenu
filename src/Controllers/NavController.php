<?php

namespace Laravelcity\NavMenu\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use League\Flysystem\Exception;
use Laravelcity\NavMenu\Models\Nav;
use Laravelcity\NavMenu\Models\NavLink;

class NavController extends Controller
{

    protected $navModel;

    public function __construct (Nav $nav)
    {
        $this->navModel = $nav;
    }

    public function index ()
    {
        $navs = $this->navModel->paginate(config('navmenu.perPage'))->groupBy('position');
        return view('NavMenu::index' , compact('navs'));
    }

    public function create ()
    {
        return view('NavMenu::create');
    }

    public function store (Request $request)
    {
        try {
            if ($this->navModel->hasNav($request->input('position') , $request->input('title'))) {
                throw new Exception(trans('NavMenu::nav-exist'));
            } else {
                if ($request->input('status' , 0) == 1)
                    Nav::removeActiveStatus($request->input('position'));

                $this->navModel->create($request->except('_token'));
                return redirect()->route(config('navmenu.as') . 'nav.index')->withSuccess(trans('NavMenu::navmenu.insert-message'));
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }


    }

    public function show ($id)
    {
        $nav = $this->navModel->findOrFail($id);
        $link_category = config('navmenu.nav_links');
        return view('NavMenu::show' , compact('nav' , 'link_category'));
    }

    public function edit ($id)
    {
        $nav = $this->navModel->findOrFail($id);
        return view('NavMenu::edit' , compact('nav'));
    }

    public function update (Request $request , $id)
    {
        $this->navModel->where('nav_id' , $id)->update($request->except('_token' , '_method'));
        return redirect()->route(config('navmenu.as') . 'nav.index')->withSuccess(trans('NavMenu::navmenu.action-message'));
    }

    public function destroy ($id)
    {
        $this->navModel->where('nav_id' , $id)->delete();
        return redirect()->route(config('navmenu.as') . 'nav.index')->withSuccess(trans('NavMenu::navmenu.action-message'));
    }

    public function activeNav ($position , $id)
    {
        Nav::removeActiveStatus($position , $id);
        return redirect()->route(config('navmenu.as') . 'nav.index')->withSuccess(trans('NavMenu::navmenu.action-message'));
    }

    public function serializeLinks (Request $request)
    {
        $links = $request->input('links');
        $this->serialize($links);
    }

    function serialize ($links , $parent = null)
    {
        $sort = 1;
        foreach ($links as $link) {
            $p = $parent ?: 0;
            NavLink::where('id' , $link['id'])->update(['parent' => $p , 'sortable' => $sort]);

            if (isset($link['children'])) {
                $this->serialize($link['children'] , $link['id']);
            }
            $sort++;
        }
    }

}
