<?php

/**
 * List all Products in Stock
 */
$app->map('/api/stocklist', "OffCut\RestfulApi\Controller\StocksController::indexAction");

/**
 * List all Products
 */
$app->map('/api/products', "OffCut\RestfulApi\Controller\ProductsController::indexAction");