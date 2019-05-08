<?php

/*
 * This file is part of the Geojson package.
 *
 * (c) Sebastian Kuhlmann <zebba@hotmail.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\Alameda\Geojson;

use Alameda\Geojson\Point;
use Alameda\Geojson\Position;
use PhpSpec\ObjectBehavior;

/**
 * @author Sebastian Kuhlmann <zebba@hotmail.de>
 * @package spec\Alameda\Geojson
 */
class PointSpec extends ObjectBehavior
{
    function let(Position $position)
    {
        $position->toArray()->willReturn([100.0, 0.0]);

        $this->beConstructedWith($position);
    }

    function it_is_initilizable()
    {
        $this->shouldHaveType(Point::class);
    }

    function it_can_be_generated_from_arrays()
    {
        $this::fromArray([100.0, 0.0]);
    }

    function it_returns_positions(Position $position)
    {
        $this->getPositions()->shouldBeArray();
        $this->getPositions()->shouldHaveCount(1);
        $this->getPositions()->shouldReturn([$position]);
    }

    function it_is_transformable_to_array()
    {
        $this->toArray()->shouldBeArray();
        $this->toArray()->shouldHaveCount(2);
        $this->toArray()->shouldReturn([100.0, 0.0]);
    }
}
