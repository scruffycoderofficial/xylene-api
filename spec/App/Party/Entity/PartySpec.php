<?php

namespace spec\OffCut\RestfulApi\App\Party\Entity;

use OffCut\RestfulApi\App\Party\Entity\Party;
use PhpSpec\ObjectBehavior;

class PartySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(Party::class);
    }
}
