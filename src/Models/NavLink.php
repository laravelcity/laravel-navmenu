<?php

namespace Laravelcity\NavMenu\Models;

use Illuminate\Database\Eloquent\Model;

class NavLink extends Model
{

    protected $table = 'nav_menu_link';
    protected $guarded = [];

    public function getMakeLinkAttribute ()
    {
        if ($this->type == 'route')
            return route($this->link);
        if ($this->type == 'link')
            return url($this->link);
    }

    public function parents ()
    {
        return self::where('parent' , $this->attributes['id'])->orderBy('sortable' , 'asc')->get();
    }

    public function nav ()
    {
        return $this->belongsTo(Nav::class , 'nav_id' , 'nav_id');
    }

}
