<?php
return [

    // ** Define Links and Api ** //
    'nav_links' => [
        'static' => [
            [
                'title' => 'خانه' ,
                'link' => url('/') ,
                'image' => ''  // optional
            ] ,
            [
                'title' => 'سری آموزشی' ,
                'link' => url('/article/courses/') ,
                'image' => ''
            ] ,
        ] ,
        'dynamic' => [
            /*
             * ////////////////////////////
             *  Api result
             * ///////////////////////////
             * result api As follows
             *  api result :
                {
                    title => val,
                    url => val,
                    image => val ===>  optional
                }
             * */


            /* [
               'title'=>'Category',
                 'controller'=> \App\Http\Controllers\CategoryController::class,
                'method'=>'getCategoriesLinkForNavigation',
                'search'=>true   // optional
            ], */

        ]
    ] ,

    // ** Router ** //
    'prefix' => '/lydadmin' ,
    'as' => 'admin.' ,
    'middleware' => ['web' , 'auth'] ,

    // ** Define menu ** //
    'register_nav_menu' => [
        'nav_menu_header' => ' Header Menu' ,
        'nav_menu_sidebar' => 'Sidebar Menu ' ,
    ] ,

    // ** perPage for nav and link lists ** //
    'perPage' => 15
];