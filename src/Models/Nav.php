<?php

namespace Laravelcity\NavMenu\Models;

use Illuminate\Database\Eloquent\Model;

class Nav extends Model
{

    protected $table = 'nav_menu';
    protected $guarded = [];
    protected $primaryKey = 'nav_id';

    public function __construct (array $attributes = [])
    {
        parent::__construct($attributes);
        $this->perPage = config('navmenu.perPage');
    }

    public static function hasNav ($position , $title)
    {
        return self::where('position' , $position)->where('title' , $title)->first();
    }

    public static function removeActiveStatus ($position , $id = null)
    {
        self::where('position' , $position)->update(['status' => 0]);

        if ($id != null)
            self::where('nav_id' , $id)->update(['status' => 1]);
    }

    public function links ()
    {
        return $this->hasMany(NavLink::class , 'nav_id');
    }

    public function getRootLinks ()
    {
        $nav_id = isset($this->attributes['nav_id']) ? $this->attributes['nav_id'] : 0;
        return NavLink::where('parent' , 0)
            ->where('nav_id' , $nav_id)
            ->orderBy('sortable' , 'asc')
            ->get();
    }

    static public function getNavWithActivePosition ($position)
    {
        if ($nav = self::where('position' , $position)->where('status' , 1)->first())
            return $nav;
        else
            return false;
    }


}
