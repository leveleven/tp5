<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
use think\Route;
Route::resource('flow', 'flow/flow');
Route::resource('storage', 'storage/storage');
Route::resource('production', 'production/production');
Route::resource('quality', 'quality/quality');


return [
    '__pattern__' => [
        'name' => '\w+',
    ],
];