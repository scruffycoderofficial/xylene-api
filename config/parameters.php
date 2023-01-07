<?php

$container->setParameter('app.name', 'Xylene API Demo');
$container->setParameter('app.root_dir', __DIR__.'/..');
$container->setParameter('app.logger.default_channel', 'app');
$container->setParameter('app.logger.file_path', '%app.root_dir%/app/var/app.log');