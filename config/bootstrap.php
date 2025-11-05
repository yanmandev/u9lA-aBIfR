<?php

require_once __DIR__ . '/bootstrap/_dotenv.php';

/**
 * @param $category
 * @param $message
 * @param array $params
 * @param null $language
 * @return string
 */
function t($category, $message, $params = [], $language = null)
{
    return Yii::t($category, $message, $params, $language);
}