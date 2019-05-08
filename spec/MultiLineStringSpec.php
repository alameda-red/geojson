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
use Alameda\Geojson\MultiLineString;
use Alameda\Geojson\Position;
use PhpSpec\ObjectBehavior;

/**
 * @author Sebastian Kuhlmann <zebba@hotmail.de>
 * @package spec\Alameda\Geojson
 */
class MultiLineStringSpec extends ObjectBehavior
{
    function let(LineString $lineStringA, LineString $lineStringB)
    {
        $this->beConstructedWith($lineStringA, $lineStringB);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(MultiLineString::class);
    }

    function it_can_be_generated_from_arrays()
    {
        $this::fromArray([
            [
                [100.0, 0.0],
                [150.0, 10.0]
            ],
            [
                [50.0, 5.0],
                [75.5, 900.0]
            ]
        ]);
    }

    function it_has_linestring(LineString $lineStringA, LineString $lineStringB)
    {
        $this->beConstructedWith($lineStringA, $lineStringB);

        $this->getLineStrings()->shouldBeArray();
        $this->getLineStrings()->shouldHaveCount(2);
        $this->getLineStrings()->shouldReturn([$lineStringA, $lineStringB]);
    }

    function it_returns_positions()
    {
        $posA1 = new Position(1, 2, 3);
        $posA2 = new Position(1, 2);
        $posB1 = new Position(1, 2);
        $posB2 = new Position(1, 2, 3);

        $lineA = new LineString($posA1, $posA2);
        $lineB = new LineString($posB1, $posB2);

        $this->beConstructedWith($lineA, $lineB);

        $this->getPositions()->shouldBeArray();
        $this->getPositions()->shouldHaveCount(2);
        $this->getPositions()->shouldReturn([[$posA1, $posA2], [$posB1, $posB2]]);
    }

    function it_is_transformable_to_array()
    {
        $posA1 = new Position(170, 45);
        $posA2 = new Position(180, 45);
        $posB1 = new Position(-180, 45);
        $posB2 = new Position(-170, 45);

        $lineA = new LineString($posA1, $posA2);
        $lineB = new LineString($posB1, $posB2);

        $this->beConstructedWith($lineA, $lineB);

        $this->toArray()->shouldBeArray();
        $this->toArray()->shouldHaveCount(2);
        $this->toArray()->shouldReturn([[[170.0, 45.0, 0.], [180.0, 45.0, 0.]], [[-180.0, 45.0, 0.], [-170.0, 45.0, 0.]]]);
    }
}
