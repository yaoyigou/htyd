<?php
/**
 * Created by PhpStorm.
 * User: chunyang
 * Date: 2017-07-27
 * Time: 13:21
 */
use App\Models\ShopConfig;


if (!function_exists('shop_config')) {
    function shop_config($code)
    {
        return Cache::tags('shop', 'config')->rememberForever($code, function () use ($code) {
            return ShopConfig::where('code', $code)->value('value');
        });
    }
}

if (!function_exists('path')) {
    function path($path, $secure = null)
    {
        return app('url')->asset($path, $secure);

    }
}


if (!function_exists('tips')) {
    function tips($message = '', int $errors = 0, array $params = [], array $headers = [])
    {
        $params['errors'] = $errors;
        throw new \App\Exceptions\TipsException($message, $params, $headers);
    }
}