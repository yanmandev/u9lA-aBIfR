<?php

namespace app\common\post\repositories;

use app\common\post\models\Post;

class PostRepository
{
    /**
     * @param string $id
     * @return Post|null
     */
    public function getPostById(string $id): ?Post
    {
        return Post::find()->byUniqueId($id)->one();
    }

    /**
     * @param int $limit
     * @return Post[]
     */
    public function getPublishedPosts(int $limit): array
    {
        return Post::find()->published()->last()->limit($limit)->all();
    }

    /**
     * @param array $ips
     * @return array
     */
    public function getPostCounts(array $ips): array
    {
        $posts = Post::find()->addSelect(['COUNT(id) count', 'ip'])->andWhere(['ip' => $ips])->groupBy('ip')->indexBy('ip')->asArray()->all();

        return array_map(fn($item) => $item['count'], $posts);
    }

    /**
     * @param string $ip
     * @return Post|null
     */
    public function getLastPostByIp(string $ip): ?Post
    {
        return Post::find()->byIp($ip)->last()->one();
    }
}