<?php

declare(strict_types=1);

namespace spec\Xylene\Annotation;

use InvalidArgumentException;
use PhpSpec\ObjectBehavior;
use Xylene\Annotation\UseCase;

/**
 * Class UseCaseSpec
 *
 * @package spec\Xylene\Annotation
 */
class UseCaseSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beConstructedWith(['value' => 'use_case']);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(UseCase::class);
    }

    public function it_throws_an_exception_if_an_unsupported_option_was_used()
    {
        $this->beConstructedWith([
            'value' => 'use_case',
            'input' => 'http',
            'response' => 'twig',
            'foo' => 'this is just silly'
        ]);
        $this->shouldThrow(new InvalidArgumentException('Unsupported options on UseCase annotation: input, response, foo'))
            ->duringInstantiation();
    }
}