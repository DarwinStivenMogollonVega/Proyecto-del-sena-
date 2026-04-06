<?php

namespace Tests;

class Schema
{
    public static function __callStatic($name, $arguments)
    {
        return call_user_func_array([\Illuminate\Support\Facades\Schema::class, $name], $arguments);
    }
}

class DB
{
    public static function __callStatic($name, $arguments)
    {
        return call_user_func_array([\Illuminate\Support\Facades\DB::class, $name], $arguments);
    }
}
