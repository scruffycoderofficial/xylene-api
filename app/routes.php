<?php

/**
 * List all Parties on record
 */
$app->map('/api/parties', "Xylene\Demo\Party\ShowParties::show");