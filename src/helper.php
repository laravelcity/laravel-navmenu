<?php

function lyda_nav_menu ($position , $attributes = [])
{
    return \Laravelcity\NavMenu\LydaNavHelpers::lyda_nav_menu($position , $attributes);
}

function lyda_nav_list ($position)
{
    return \Laravelcity\NavMenu\LydaNavHelpers::lyda_nav_list($position);
}

if (!function_exists('button')) {
    /**
     * button
     *
     * @param string $url
     * @param string $title
     * @param string $icon
     * @param string $color
     * @param bool $active
     * @return string
     */
    function button ($url , $title = null , $icon = 'circle' , $color = 'primary' , $active = true)
    {
        //setup output
        $return = '<a class="btn btn-sm btn-';
        $return .= $color;
        //active class
        $return .= (!$active) ? ' disabled' : null;
        $return .= '" href="';
        //active url
        $return .= ($active) ? $url : '#';
        $return .= '" title="';
        $return .= $title;
        $return .= '"><i class="fa fa-';
        $return .= $icon;
        $return .= '"></i></a>';
        //return
        return $return;
    }
}
if (!function_exists('button_view')) {
    /**
     * view button
     *
     * similar but not identical to 'open button'
     * this button is more for User facing
     *
     * @param string $url
     * @param string $title
     * @return string
     */
    function button_view ($url , $title = 'View')
    {
        //setup output
        $return = '<a class="btn btn-sm btn-info" href="';
        $return .= $url;
        $return .= '" title="';
        $return .= $title;
        $return .= '"><i class="fa fa-fw fa-info"></i></a>';
        //return
        return $return;
    }
}
if (!function_exists('button_manage')) {
    /**
     * manage button
     *
     * @param string $url
     * @param string $title
     * @return string
     */
    function button_manage ($url , $title = 'Manage')
    {
        //setup output
        $return = '<a class="btn btn-sm btn-primary" href="';
        $return .= $url;
        $return .= '" title="';
        $return .= $title;
        $return .= '"><i class="fa fa-User"></i></a>';
        //return
        return $return;
    }
}
if (!function_exists('button_show')) {
    /**
     * open button
     *
     * @param string $url
     * @param string $title
     * @return string
     */
    function button_show ($url , $title = 'Open')
    {
        //setup output
        $return = '<a class="btn btn-sm btn-primary" href="';
        $return .= $url;
        $return .= '" title="';
        $return .= $title;
        $return .= '"><i class="fa fa-arrow-circle-right"></i></a>';
        //return
        return $return;
    }
}
if (!function_exists('button_edit')) {
    /**
     * edit button
     *
     * @param string $url
     * @param string $title
     * @return string
     */
    function button_edit ($url , $title = 'Edit')
    {
        //setup output

        $return = '<a class="on-default edit-row" href="';
        $return .= $url;
        $return .= '" title="';
        $return .= $title;
        $return .= '"><i class="fa fa-pencil"></i></a>';
        //return
        return $return;
    }
}
if (!function_exists('button_delete')) {
    /**
     * delete button
     *
     * @param string $url
     * @param string $message
     * @param string $buttonTitle
     * @param string $title
     * @return string
     */
    function button_delete ($url , $message = null , $buttonTitle = 'Delete' , $title = null)
    {
        //setup output
        $return = '<a class="on-default remove-row  confirm delete " data-url="';
        $return .= $url;
        $return .= '" data-title="';
        $return .= $title;
        $return .= '" data-message="';
        $return .= $message;
        $return .= '" title="';
        $return .= $buttonTitle;
        $return .= '"><i class="fa fa-trash-o"></i></a>';
        //return
        return $return;
    }
}
if (!function_exists('button_destroy')) {
    /**
     * delete button
     *
     * @param string $url
     * @param string $message
     * @param string $buttonTitle
     * @param string $class
     * @return string
     */
    function button_destroy ($path , $message = null , $buttonTitle = 'Delete' , $class = "")
    {

        if (is_array($path)) {
            $params = $path;
            $route_name = array_shift($params);
            $action = route($route_name , $params);
        } else
            $action = url($path);

        //setup output
        $return = '<form name="button-destroy" method="POST" class="delete_form" action="' . $action . '"  accept-charset="UTF-8" style="display: inline-block;">';
        $return .= '<input name="_method" type="hidden" value="DELETE">';
        $return .= '<input name="_token" type="hidden" value="' . csrf_token() . '">';
        $return .= '<button  data-method="delete"   data-action="' . $action . '"  style="border:none;background:none" type="button" class="btn btn-danger btn-sm  confirm_delete ' . $class;
        $return .= ' data-message="';
        $return .= $message;
        $return .= '" title="';
        $return .= $buttonTitle;
        $return .= '"><i class="fa fa-trash"></i> ' . $buttonTitle . '</a>';
        $return .= '</form>';
        //return
        return $return;
    }
}

if (!function_exists('button_cancel')) {
    /**
     * cancel button
     *
     * @param string $url
     * @param string $message
     * @param string $buttonTitle
     * @param string $title
     * @return string
     */
    function button_cancel ($url , $message = null , $buttonTitle = 'Cancel' , $title = null)
    {
        //setup output
        $return = '<a class="btn btn-sm btn-danger confirm" data-url="';
        $return .= $url;
        $return .= '" data-title="';
        $return .= $title;
        $return .= '" data-message="';
        $return .= $message;
        $return .= '" title="';
        $return .= $buttonTitle;
        $return .= '"><i class="fa fa-minus-square"></i></a>';
        //return
        return $return;
    }
}
if (!function_exists('button_back')) {
    /**
     * back button
     *
     * @return string
     */
    function button_back ()
    {
        return '<a href="' . URL::previous() . '" class="btn btn-success"><i class="fa fa-arrow-circle-left"></i> Back</a>';
    }
}