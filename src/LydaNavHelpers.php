<?php

namespace Laravelcity\NavMenu;


use Laravelcity\NavMenu\Models\Nav;

class LydaNavHelpers
{
    /*********************
     * for management
     ********************/

    // ** get all links for make navigation ** //
    static function getLinksList ($nav_id , $array , $r = true)
    {
        $el = "";
        if (count($array) > 0) {
            $rList = $array;
            if ($r) {
                $rList = array_where($array , function ($link) {
                    if (isset($link['parent']))
                        return $link['parent'] == 0;
                    else
                        return $link;
                });
            }

            foreach ($rList as $link) {
                $el .= "<div style='    background: #fbfbfb;  padding: 8px;margin-bottom: 5px'><div style='font-size: 13px' class='pull-right'>{$link['title']} </div>";
                $el .= ' <div class="pull-left"><button style="    padding: 0 5px;"   data-nav-id="' . @$nav_id . '"   data-title="' . $link['title'] . '" data-image="' . @$link['image'] . '" data-link="' . $link['link'] . '" data-type="' . (@$link['type'] ?: 'link') . '" class="btn btn-cms btn-xs saveLink">+</button></div>';
                $el .= '<div class="clearfix"></div>';
                $el .= '</div>';


                if (isset($link['id']) && isset($link['parent']))
                    $el .= static::getLinksList($nav_id , static::children($link['id'] , $array) , false);
            }
        }
        return $el;
    }

    // ** get child links ** //
    static function children ($id , $array)
    {
        $filtered = array_where($array , function ($link) use ($id) {
            return $link['parent'] == $id;
        });
        return $filtered;
    }

    // ** get menu list nestable for manage ** //
    static function makeListForView ($links)
    {
        $list = '';
        foreach ($links as $link) {
            $list .= '<li class="dd-item" data-id="' . $link->id . '">';
            $list .= '<div class="buttons"><button data-link-id="' . $link->id . '" class="btn btn-danger removeLink">' . trans('NavMenu::navmenu.delete') . '</button>';
            $list .= '<button data-image="' . @$link->image . '"   data-id="' . $link->id . '" data-title="' . $link->title . '" data-link="' . $link->link . '" data-type="' . @$link->type . '" class="btn btn-primary editLink">' . trans('NavMenu::navmenu.edit') . '</button></div>';
            $list .= '<div class="dd-handle">' . $link->title . '</div>';
            if (count($link->parents()) > 0) {
                $p = static::makeListForView($link->parents());
                $list .= '<ol class="dd-list">' . $p . '</ol>';
            }
            $list .= '</li>';
        }

        return '<ol class="dd-list">' . $list . '</ol>';
    }


    /****************
     * for view
     ****************/

    // ** get menu list** //
    static function lyda_nav_list ($position)
    {
        if ($nav = Nav::getNavWithActivePosition($position)) {
            return static::LinksList($nav->getRootLinks());
        } else
            return false;
    }

    // ** get menu ul list ** //
    static function lyda_nav_menu ($position , $attributes = [])
    {

        if ($nav = Nav::getNavWithActivePosition($position)) {
            return static::makeNavUlList($nav->getRootLinks() , $attributes);
        } else
            return false;
    }

    // ** helper for lyda_nav_menu($position) ** //
    static function makeNavUlList ($links , $attributes)
    {
        if (count($links) > 0) {
            return static::htmlUl($links , $attributes);
        } else
            return false;
    }

    // ** get nav list with children ** //
    static function LinksList ($links)
    {
        $data = [];
        foreach ($links as $link) {
            $data[] = [
                'id' => $link->id ,
                'title' => $link->title ,
                'link' => $link->link ,
                'parent' => $link->parent ,
                'image' => $link->image ,
                'type' => @$link->type ?: 'link' ,
                'children' => static::LinksList($link->parents())
            ];
        }

        return $data;
    }

    // ** make html ul and helper for makeNavUlList($links)  ** //
    static function htmlUl ($links , $attributes)
    {
        $li = "";
        $i = 0;
        if ($links) {
            foreach ($links as $link) {
                if ($link->permission == '' || ($link->permission != '' && auth()->user()->can($link->permission))) {
                    $parents = $link->parents();
                    $class = count($parents) > 0 ? (isset($attributes['has-sub-class']) ? $attributes['has-sub-class'] : 'has-sub') : '';
                    $li_class = @$attributes['li-class'] ?: '';
                    $a_class = @$attributes['a-class'] ?: '';
                    if ($i == 0)
                        $li_class .= ' active';

                    $li .= "<li class='$class $li_class'><a class='$a_class' href='" . $link->makeLink . "'><i class='{$link->image}'></i>{$link->title}</a>";
                    if (count($parents) > 0)
                        $li .= static::htmlUl($parents , array_merge($attributes , ['hasUl' => true]));
                    $li .= '</li>';
                }
                $i++;
            }
        }
        $root_ul = '';
        if (count($attributes['root_ul']) > 0) {
            foreach ($attributes['root_ul'] as $r => $v) {
                $root_ul .= ' ' . $r . '="' . $v . '"';
            }

        }
        if (isset($attributes['hasUl'])) {
            if ($attributes['hasUl'] == true) {
                $hasUl_attr = '';
                if (count($attributes['hasUl_attr']) > 0) {
                    foreach ($attributes['hasUl_attr'] as $r => $v) {
                        $hasUl_attr .= ' ' . $r . '=' . $v;
                    }
                }
                return "<ul $hasUl_attr >$li</ul>";

            } else
                return $li;
        } else
            return "<ul $root_ul>$li</ul>";
    }

}