<?php

use yii\db\Migration;

class m251106_124040_create_post_indexes extends Migration
{
    public function safeUp()
    {
        $this->createIndex('i_post_unique_id', '{{%post}}', 'unique_id');
        $this->createIndex('i_post_unique_status_created_at', '{{%post}}', ['status', 'created_at']);
        $this->createIndex('i_post_unique_ip_created_at', '{{%post}}', ['ip', 'created_at']);
    }

    public function safeDown()
    {
        $this->dropIndex('i_post_unique_id', '{{%post}}');
        $this->dropIndex('i_post_unique_status_created_at', '{{%post}}');
        $this->dropIndex('i_post_unique_ip_created_at', '{{%post}}');
    }
}
