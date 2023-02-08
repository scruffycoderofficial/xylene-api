<?php

$container->setParameter('app.name', 'Xylene API Demo');
$container->setParameter('app.root_dir', __DIR__.'/..');
$container->setParameter('app.logger.default_channel', 'app');
$container->setParameter('app.logger.file_path', '%app.root_dir%/app/var/app.log');

$container->setParameter('app.doctrine.orm.proxies_dir', '');
$container->setParameter('app.doctrine.orm.auto_generate_proxies', true);
$container->setParameter('app.doctrine.orm.default_cache', 'array');
$container->setParameter('app.doctrine.orm.entity_path', ['%app.root_dir%/app/Demo/Party/Entity']);
$container->setParameter('app.doctrine.orm.dev_mode', true);
$container->setParameter('app.doctrine.orm.db_params', [
    'driver' => 'pdo_sqlite',
    'url' => getenv('DATABASE_URL'),
]);
$container->setParameter('app.doctrine.orm.proxies_namespace', 'Xylene\Demo\Party\Entity\Proxy');