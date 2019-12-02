<?php

namespace TradefiUBA;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{

    public function user()
    {
        return $this->belongsTo('TradefiUBA\User');
    }

    protected $guarded = ['id'];
    // protected $connection = 'conn2';

    public static function resolveId()
    {
        return Auth::check() ? Auth::user()->getAuthIdentifier() : null;
    }

    public function parent()
    {
        return $this->hasOne('TradefiUBA\Menu', 'id', 'parent_id');
    }

    public function children()
    {
        return $this->hasMany('TradefiUBA\Menu', 'parent_id', 'id');
    }

    public function roles()
    {
        return $this->belongsToMany('TradefiUBA\Role');
    }

    public function abbreviation($arr)
    {
        $splitted = explode(' ', $arr);
        foreach ($splitted as $abbr) {
            return substr($abbr, 0, 2);
        }
    }

    public function hasSubmenu($menu_id)
    {
        $menu_children = Menu::where('parent_id', '<>', 0)->get();
        // dd($menu_children->groupBy('parent_id'));
        $user_menus = collect(\Auth::user()->roles()->first()->menus);
        // dd($user_menus->groupBy('parent_id'));
        $menu      = Menu::find($menu_id);
        $intersect = $menu->children->intersect($user_menus);
        // dd($intersect->all());
        //

        if ($menu->children->count() > 0) {
            echo "<ul class=\"sub-menu\">";
            foreach ($intersect->all() as $key => $child) {
                if ($child->children()->count() > 0) {
                    echo '<li><a href="javascript:;">' .
                    '<span class="top-level title">' . $child->name . '</span>' .
                    '<span class="arrow"></span></a>' .
                    '<span class="icon-thumbnail">' . $this->abbreviation($child->name) . '</span>';
                } else {
                    if ($child->route == null) {
                        echo '<li><a href="javascript:;">' . $child->name . '</a>';
                        echo '<span class="icon-thumbnail">' . $this->abbreviation($child->name) . '</span>';
                    } else {
                        echo '<li>' . link_to_route(($child->route != '#' ? $child->route : "#"), $title = $child->name, $parameters = array(), $attributes = array());
                        echo '<span class="icon-thumbnail">' . $this->abbreviation($child->name) . '</span>';
                    }

                }
                $this->hasSubmenu($child->id);
                echo "</li>";
            }
            echo "</ul>";
        } else {
            return null;
        }

        // dd($menu_children);
    }

}
