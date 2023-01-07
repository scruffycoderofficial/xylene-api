<?php

namespace spec\OffCut\RestfulApi\App\Party;

use OffCut\RestfulApi\App\Party\PartyController;
use PhpSpec\ObjectBehavior;

class PartyControllerSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(PartyController::class);
    }
}
