<?php

namespace App\Http\Service\Traits;

trait CrudableTrait {
    public static function destroy($id, $mass=false) {
        if($mass) return self::MODEL::whereIn('id', $id)->delete();
        return self::MODEL::where('id', $id)->delete();
    }

    public static function store($data, $mass=false) {
        if($mass) return self::MODEL::insert($data);
        return self::MODEL::create($data);
    }

    public static function update($id, $data, $mass=false) {
        if($mass) return self::MODEL::whereIn('id', $id)->update($data);
        return self::MODEL::where('id', $id)->update($data);
    }
}