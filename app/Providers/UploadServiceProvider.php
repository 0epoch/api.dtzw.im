<?php
/**
 * Created by PhpStorm.
 * User: 0EPOCH
 * Date: 2018/7/6
 * Time: 23:34
 */

namespace App\Providers;

use Illuminate\Support\Facades\Storage;
use League\Flysystem\Filesystem;
use App\Service\Upload\CosAdapter;
use Illuminate\Support\ServiceProvider;

class UploadServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Storage::extend('cos', function ($app, $config) {

            return new Filesystem(new CosAdapter($config), $config);
        });
    }
}