<?php

namespace spec\Xylene\Demo\App\Party;

use PhpSpec\ObjectBehavior;
use Xylene\Demo\App\Party\ShowParties;

/**
 * Class ShowPartiesSpec
 *
 * @package spec\Xylene\Demo\App\Party
 * @author Luyanda Siko <sikoluyanda@gmail.com>
 */
class ShowPartiesSpec extends ObjectBehavior
{
    /**
     * Subject can be instantiated
     */
    function it_is_initializable()
    {
        $this->shouldHaveType(ShowParties::class);
    }
}
