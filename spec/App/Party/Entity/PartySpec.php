<?php

namespace spec\Xylene\Demo\App\Party\Entity;

use PhpSpec\ObjectBehavior;
use Xylene\Demo\App\Party\Entity\Party;

/**
 * Class PartySpec
 *
 * @package spec\Xylene\Demo\App\Party\Entity
 * @author Luyanda Siko <sikoluyanda@gmail.com>
 */
class PartySpec extends ObjectBehavior
{
    /**
     * Subject can be instantiated
     */
    function it_is_initializable()
    {
        $this->shouldHaveType(Party::class);
    }
}
