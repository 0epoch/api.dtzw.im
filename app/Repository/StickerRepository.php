<?php
/**
 * Created by PhpStorm.
 * User: gtianx
 * Date: 18-4-9
 * Time: 下午10:45
 */

namespace App\Repository;

use App\Models\Sticker;
use App\Models\StickerTag;
use App\Models\StickerUrl;

class StickerRepository
{

    public function findStickers()
    {
        $stickers = Sticker::with(['tags', 'urls'])->get();
        foreach ($stickers as $k => $sticker)
        {
            $stickers[$k]['tags'] = $sticker->tags->sticker_id;
            $stickers[$k]['url'] = $sticker->urls->sticker_url;
        }
        return $stickers;
    }

    public function getStickerCommentsById($id)
    {
        $sticker = Sticker::with('comments')->where('id', $id)->first();
        return $sticker->commets;
    }

    public function saveStickers($attribute, array $urls, $tagId)
    {
        $sticker = new Sticker();
        $sticker->describe = $attribute['describe'];
        $sticker->user_id = $attribute['describe'];
        $sticker->author = $attribute['author'];
        $sticker->save();

        $stickerUrl = [];
        foreach($urls as $k => $url) {
            $stickerUrl[$k] = new StickerUrl();
            $stickerUrl[$k]->sticker_url = $url;
        }
        //一对多关联插入数据(多条)
        $sticker->urls()->saveMany($stickerUrl);
        //多对多关联 自动写入关联表数据
        $sticker->tags()->attach($tagId);
        return $sticker;
    }

    public function removeSticker($id)
    {
        Sticker::destroy($id);
        //删除标签关联
        StickerUrl::where('sticker_id', $id)->delete();
        //删除url关联
        StickerTag::where('sticker_id', $id)->delete();
    }
    /**
     * 增加表情包评论数
     */
    public function addCommentsNum($id)
    {
        Sticker::where('id', $id)->increment('comments_num');
        return true;
    }
}