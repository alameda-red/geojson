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

use Alameda\Geojson\Exception\NotClosedLineStringException;
use Alameda\Geojson\LineString;
use Alameda\Geojson\Polygon;
use Alameda\Geojson\Position;
use PhpSpec\ObjectBehavior;

/**
 * @author Sebastian Kuhlmann <zebba@hotmail.de>
 * @package spec\Alameda\Geojson
 */
class PolygonSpec extends ObjectBehavior
{
    function let(LineString $outer, LineString $hole1, LineString $hole2)
    {
        $outer->isClosed()->willReturn(true);
        $outer->toArray()->willReturn([[102.0, 2.0], [103.0, 2.0], [103.0, 3.0], [102.0, 3.0], [102.0, 2.0]]);

        $hole1->isClosed()->willReturn(true);
        $hole1->toArray()->willReturn([[100.0, 0.0], [101.0, 0.0], [101.0, 1.0], [100.0, 1.0], [100.0, 0.0]]);

        $hole2->isClosed()->willReturn(true);
        $hole2->toArray()->willReturn([[100.2, 0.2], [100.2, 0.8], [100.8, 0.8], [100.8, 0.2], [100.2, 0.2]]);

        $this->beConstructedWith($outer, $hole1, $hole2);
    }

    function it_can_not_be_constructed_with_open_outer_linestring(LineString $outer)
    {
        $outer->isClosed()->willReturn(false);

        $this->shouldThrow(NotClosedLineStringException::class)->duringInstantiation();
    }

    function it_can_not_be_constructed_with_open_hole(LineString $hole1)
    {
        $hole1->isClosed()->willReturn(false);

        $this->shouldThrow(NotClosedLineStringException::class)->duringInstantiation();
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Polygon::class);
    }

    function it_can_be_generated_from_arrays()
    {
        $this::fromArray([[0.0, 0.0], [100.0, 0.0], [100.0, 100.0], [100.0, 0.0], [0.0, 0.0]]);
    }

    function it_returns_if_it_has_holes()
    {
        $this->hasHoles()->shouldReturn(true);
    }

    function it_returns_outer_linestring(LineString $outer)
    {
        $this->getOuterLineString()->shouldReturn($outer);
    }

    function it_returns_hole_linestrings(LineString $hole1, LineString $hole2)
    {
        $this->getHoleLineStrings()->shouldBeArray();
        $this->getHoleLineStrings()->shouldHaveCount(2);
        $this->getHoleLineStrings()->shouldReturn([$hole1, $hole2]);
    }

    function it_returns_positions_of_the_outer_linestring(LineString $outer, Position $posA, Position $posB)
    {
        $outer->getPositions()->willReturn([$posA, $posB]);

        $this->getOuterPositions()->shouldBeArray();
        $this->getOuterPositions()->shouldHaveCount(2);
        $this->getOuterPositions()->shouldReturn([$posA, $posB]);
    }

    function it_returns_positions_of_the_hole_linestrings(
        LineString $hole1,
        Position $posA1,
        Position $posA2,
        LineString $hole2,
        Position $posB1,
        Position $posB2
    ) {
        $hole1->getPositions()->willReturn([$posA1, $posA2]);
        $hole2->getPositions()->willReturn([$posB1, $posB2]);

        $this->getHolePositions()->shouldBeArray();
        $this->getHolePositions()->shouldHaveCount(2);
        $this->getHolePositions()->shouldReturn([[$posA1, $posA2], [$posB1, $posB2]]);
    }

    function it_returns_positions(
        LineString $outer,
        Position $posO1,
        Position $posO2,
        LineString $hole1,
        Position $posH1,
        Position $posH2,
        LineString $hole2,
        Position $posH3,
        Position $posH4
    ) {
        $outer->getPositions()->willReturn([$posO1, $posO2]);
        $hole1->getPositions()->willReturn([$posH1, $posH2]);
        $hole2->getPositions()->willReturn([$posH3, $posH4]);

        $this->getPositions()->shouldBeArray();
        $this->getPositions()->shouldHaveCount(3);
        $this->getPositions()->shouldReturn([
            [$posO1, $posO2],
            [$posH1, $posH2],
            [$posH3, $posH4]
        ]);
    }

    function it_is_transformable_to_array_without_holes(LineString $outer)
    {
        $outer->toArray()->willReturn([[100.0, 0.0], [101.0, 0.0], [101.0, 1.0], [100.0, 1.0], [100.0, 0.0]]);

        $this->beConstructedWith($outer);

        $this->toArray()->shouldBeArray();
        $this->toArray()->shouldHaveCount(1);
        $this->toArray()->shouldReturn([
            [
                [100.0, 0.0], [101.0, 0.0], [101.0, 1.0], [100.0, 1.0], [100.0, 0.0]
            ]
        ]);
    }

    function it_is_transformable_to_array_with_hole(LineString $outer, LineString $hole1)
    {
        $outer->toArray()->willReturn([
            [100.0, 0.0],
            [101.0, 0.0],
            [101.0, 1.0],
            [100.0, 1.0],
            [100.0, 0.0]
        ]);
        $hole1->toArray()->willReturn([
            [100.8, 0.8],
            [100.8, 0.2],
            [100.2, 0.2],
            [100.2, 0.8],
            [100.8, 0.8]
        ]);

        $this->beConstructedWith($outer, $hole1);

        $this->toArray()->shouldBeArray();
        $this->toArray()->shouldHaveCount(2);
        $this->toArray()->shouldReturn([
            [
                [100.0, 0.0],
                [101.0, 0.0],
                [101.0, 1.0],
                [100.0, 1.0],
                [100.0, 0.0]
            ],
            [
                [100.8, 0.8],
                [100.8, 0.2],
                [100.2, 0.2],
                [100.2, 0.8],
                [100.8, 0.8]
            ]
        ]);
    }
}
