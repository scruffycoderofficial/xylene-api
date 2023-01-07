<?php

/**
 * List all Parties on record
 */
$app->map('/api/parties', "OffCut\RestfulApi\App\Party\PartyController::parties");