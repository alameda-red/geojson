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

use Alameda\Geojson\MultiPolygon;
use Alameda\Geojson\Polygon;
use Alameda\Geojson\Position;
use PhpSpec\ObjectBehavior;

/**
 * @author Sebastian Kuhlmann <zebba@hotmail.de>
 * @package spec\Alameda\Geojson
 */
class MultiPolygonSpec extends ObjectBehavior
{
    function let(Polygon $poly1, Polygon $poly2)
    {
        $this->beConstructedWith($poly1, $poly2);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(MultiPolygon::class);
    }

    function it_can_be_generated_from_arrays()
    {
        $this::fromArray([
            [[[180.0, 40.0], [180.0, 50.0], [170.0, 50.0], [170.0, 40.0], [180.0, 40.0]]],
            [[[-170.0, 40.0], [-170.0, 50.0], [-180.0, 50.0], [-180.0, 40.0], [-170.0, 40.0]]]
        ]);

        $this::fromArray([
            [
                [[-47.900, -14.944], [-51.591, -19.911], [-41.110, -21.309], [-43.395, -15.390], [-47.900, -14.944]],
                [[-46.625, -17.140], [-47.548, -16.804], [-46.230, -16.699], [-45.351, -19.311], [-46.625, -17.140]],
                [[-44.406, -18.375], [-44.428, -20.097], [-42.934, -18.979], [-43.527, -17.602], [-44.406, -18.375]]
            ]
        ]);
        $this::fromArray([
            [
                [[102.0, 2.0], [103.0, 2.0], [103.0, 3.0], [102.0, 3.0], [102.0, 2.0]]
            ],
            [
                [[100.0, 0.0], [101.0, 0.0], [101.0, 1.0], [100.0, 1.0], [100.0, 0.0]],
                [[100.2, 0.2], [100.2, 0.8], [100.8, 0.8], [100.8, 0.2], [100.2, 0.2]]
            ]
        ]);
    }

    function it_returns_polygons(Polygon $poly1, Polygon $poly2)
    {
        $this->getPolygons()->shouldBeArray();
        $this->getPolygons()->shouldHaveCount(2);
        $this->getPolygons()->shouldReturn([$poly1, $poly2]);
    }

    function it_returns_positions(
        Polygon $poly1,
        Position $posA1,
        Position $posA2,
        Polygon $poly2,
        Position $posB1,
        Position $posB2
    )
    {
        $poly1->getPositions()->willReturn([$posA1, $posA2]);
        $poly2->getPositions()->willReturn([$posB1, $posB2]);

        $this->getPositions()->shouldBeArray();
        $this->getPositions()->shouldHaveCount(2);
        $this->getPositions()->shouldReturn([
            [$posA1, $posA2],
            [$posB1, $posB2],
        ]);
    }
}
