<?php

declare(strict_types=1);

namespace spec\Xylene\Annotation;

use PhpSpec\ObjectBehavior;
use Xylene\Annotation\InputProcessor;

/**
 * Class InputProcessorSpec.
 */
class InputProcessorSpec extends ObjectBehavior
{
    public function let() {
        $this->beConstructedWith([
            'value' => 'http',
            'order' => 'GPCS',
            'map' => ['foo' => 'baz'],
        ]);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(InputProcessor::class);
    }

    public function it_sets_name_and_options_through_constructor()
    {
        $annotationOptions = [
            'value' => 'http',
            'order' => 'GPCS',
            'map' => ['foo' => 'bar'],
        ];

        $this->beConstructedWith($annotationOptions);

        $this->getName()->shouldBe('http');
        $this->getOptions()->shouldBe([
            'order' => 'GPCS',
            'map' => ['foo' => 'bar'],
        ]);
    }

    public function it_throws_an_exception_if_no_value_was_given()
    {
        $this->beConstructedWith([]);
        $this->shouldThrow(\InvalidArgumentException::class)->duringInstantiation();
    }
}
