<?php

namespace App\Models;

class Category extends Base
{
    /**
     * 删除数据
     *
     * @param array $map
     * @return bool
     */
    public function deleteData($map)
    {
        // 先获取分类id
        $categoryIdArray = $this
            ->whereMap($map)
            ->pluck('id')
            ->toArray();
        // 获取分类下的文章数
        $articleCount = Article::whereIn('category_id', $categoryIdArray)->count();
        // 如果分类下存在文章；则需要下删除文章
        if ($articleCount !== 0) {
            flashMessage('请先删除分类下的文章', false);
            return false;
        }
        // 删除分类
        return parent::deleteData($map);
    }
}
