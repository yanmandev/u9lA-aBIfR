<?php

namespace app\common\post\models;

class PostQuery extends \yii\db\ActiveQuery
{
    public function byUniqueId(string $id): self
    {
        return $this->andWhere(['unique_id' => $id]);
    }

    public function byEmail(string $email): self
    {
        return $this->andWhere(['email' => $email]);
    }

    public function byIp(string $ip): self
    {
        return $this->andWhere(['ip' => $ip]);
    }

    public function published(): self
    {
        return $this->andWhere(['status' => Post::STATUS_PUBLISHED]);
    }

    public function last(): self
    {
        return $this->orderBy(['created_at' => SORT_DESC, 'id' => SORT_DESC]);
    }

    /**
     * {@inheritdoc}
     * @return Post[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Post|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
