<?php

declare(strict_types=1);

namespace spec\Xylene\Container;

use Xylene\Container\Container;
use Xylene\Exception\ItemNotFoundException;
use Xylene\Processor\Input\InputProcessorInterface;
use Xylene\Contract\UseCaseInterface;
use PhpSpec\ObjectBehavior;

class ContainerSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(Container::class);
    }

    public function it_stores_an_item_in_the_container(UseCaseInterface $useCase, InputProcessorInterface $inputProcessor)
    {
        $this->set('use_case', $useCase);
        $this->set('input_processor', $inputProcessor);

        $this->get('use_case')->shouldBe($useCase);
        $this->get('input_processor')->shouldBe($inputProcessor);
    }

    public function it_throws_an_exception_if_service_was_not_found()
    {
        $this->shouldThrow(new ItemNotFoundException('Item "no_such_service_here" not found.'))
            ->duringGet('no_such_service_here');
    }
}