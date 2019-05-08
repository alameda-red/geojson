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

use Alameda\Geojson\LineString;
use Alameda\Geojson\Position;
use PhpSpec\ObjectBehavior;

/**
 * @author Sebastian Kuhlmann <zebba@hotmail.de>
 * @package spec\Alameda\Geojson
 */
class LineStringSpec extends ObjectBehavior
{
    function let(Position $posA, Position $posB)
    {
        $posA->toArray()->willReturn([100.0, 0.0]);
        $posB->toArray()->willReturn([101.0, 1.0]);

        $this->beConstructedWith($posA, $posB);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(LineString::class);
    }

    function it_can_be_generated_from_arrays()
    {
        $this::fromArray([[100.0, 0.0], [200.0, 10.0]]);
        $this::fromArray([[100.0, 0.0, 50.], [200.0, 10.0, 100.]]);
    }

    function it_returns_positions(Position $posA, Position $posB)
    {
        $this->getPositions()->shouldBeArray();
        $this->getPositions()->shouldHaveCount(2);
        $this->getPositions()->shouldReturn([$posA, $posB]);
    }

    function it_knows_if_it_is_closed(Position $posA, Position $posB)
    {
        $posA->equals($posB)->willReturn(true);

        $this->isClosed()->shouldReturn(true);

        $posA->equals($posB)->willReturn(false);

        $this->isClosed()->shouldReturn(false);
    }

    function it_is_transformable_to_array()
    {
        $this->toArray()->shouldBeArray();
        $this->toArray()->shouldHaveCount(2);
        $this->toArray()->shouldReturn([[100.0, 0.0], [101.0, 1.0]]);
    }
}
