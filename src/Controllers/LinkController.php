<?php

namespace Laravelcity\NavMenu\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Input;
use Laravelcity\NavMenu\LydaNavHelpers;
use Laravelcity\NavMenu\Models\NavLink;

class LinkController extends Controller
{

    protected $navLink;

    public function __construct (NavLink $nav)
    {
        $this->navLink = $nav;
    }

    public function index ()
    {
        $nav_id = Input::get('nav_id' , 0);
        $links = $this->navLink->where('nav_id' , $nav_id)->where('parent' , 0)->orderby('sortable' , 'asc')->get();
        $lists = LydaNavHelpers::makeListForView($links);
        return view('NavMenu::links' , compact('links' , 'nav_id' , 'lists'))->render();
    }

    public function store (Request $request)
    {
        $sort = $this->navLink
            ->where('nav_id' , $request->input('nav_id'))
            ->orderBy('sortable' , 'desc')
            ->first();
        if ($sort)
            $sort = $sort->sortable + 1;
        else
            $sort = 1;

        $request->request->add(['sortable' => $sort]);
        $this->navLink->create($request->except('_token'));
    }

    public function show ($id)
    {
        $nav = $this->navLink->findOrFail($id);
        $link_category = config('navmenu.nav_links');
        return view('NavMenu::show' , compact('nav' , 'link_category'));
    }

    public function edit ($id)
    {
        $nav = $this->navLink->findOrFail($id);
        return view('NavMenu::edit' , compact('nav'));
    }

    public function update (Request $request , $id)
    {
        $this->navLink->where('id' , $id)->update($request->except('_token'));
    }

    public function removeLink ($id)
    {
        $this->navLink->findOrfail($id)->delete();
        $this->navLink->where('parent' , $id)->update([
            'parent' => 0
        ]);
    }

    public function search ()
    {
        $nav_id = Input::get('nav_id' , 0);
        $title = Input::get('title' , 0);
        $controller = Input::get('controller');
        $method = Input::get('method');
        $list = LydaNavHelpers::getLinksList($nav_id , app()->call(
            [app($controller) , $method] , ['title' => $title]
        ));
        return $list;
    }

}
