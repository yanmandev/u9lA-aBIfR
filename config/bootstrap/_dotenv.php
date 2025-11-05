<?php

Yii::$container->setSingleton(\Dotenv\Dotenv::class, function () {
    $env = Dotenv\Dotenv::createUnsafeImmutable(dirname(__DIR__, 2));

    $env->safeLoad();
    $env->required('YII_DEBUG');
    $env->required('YII_ENV');
    $env->required('COOKIE_VALIDATION_KEY');
    $env->required('DB_DSN');
    $env->required('DB_USER');
    $env->required('DB_PASSWORD');

    return $env;
});

Yii::$container->get(\Dotenv\Dotenv::class);