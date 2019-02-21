<?php
/**
 * Created by PhpStorm.
 * User: gtianx
 * Date: 18-4-9
 * Time: 下午10:46
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Sticker;

class StickersController
{
    use RepositoryTrait;

    public function index()
    {
        $stickers = $this->getStickerRepository()->findStickers();
        return response()->json($stickers);
    }

    public function create(Request $request)
    {
        $attributes = $request->all();
        $path = $request->file('sticker')->store('uploads', 'stickers');

        $sticker = $this->getStickerRepository()->saveStickers($attributes, (array)$path, [1,2,3]);
        return response()->json($sticker);
    }


    public function remove($id)
    {
        //根据主键直接删除
        Sticker::destroy($id);
        $this->getStickerRepository()->removeSticker($id);
        return response()->json(['msg'=>'ok']);
    }
}