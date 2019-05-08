<?php

/*
 * This file is part of the Geojson package.
 *
 * (c) Sebastian Kuhlmann <zebba@hotmail.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tests\Alameda\Geojson;

use Alameda\Geojson\LineString;
use Alameda\Geojson\MultiPolygon;
use Alameda\Geojson\Polygon;
use Alameda\Geojson\Position;
use PHPUnit\Framework\TestCase;

/**
 * @author Sebastian Kuhlmann <zebba@hotmail.de>
 * @package Tests\Alameda\Geojson
 */
class MultiPolygonTest extends TestCase
{
    public function testGetPolygonPositions()
    {
        $outerPoly1 = new LineString(
            new Position(180.0, 40.0),
            new Position(180.0, 50.0),
            new Position(170.0, 50.0),
            new Position(170.0, 40.0),
            new Position(180.0, 40.0)
        );
        $poly1 = new Polygon($outerPoly1);

        $outerPoly2 = new LineString(
            new Position(-170.0, 40.0),
            new Position(-170.0, 50.0),
            new Position(-180.0, 50.0),
            new Position(-180.0, 40.0),
            new Position(-170.0, 40.0)
        );
        $poly2 = new Polygon($outerPoly2);

        $outerPoly3 = new LineString(
            new Position(100.0, 0.0),
            new Position(101.0, 0.0),
            new Position(101.0, 1.0),
            new Position(100.0, 1.0),
            new Position(100.0, 0.0)
        );
        $holePoly3 = new LineString(
            new Position(100.8, 0.8),
            new Position(100.8, 0.2),
            new Position(100.2, 0.2),
            new Position(100.2, 0.8),
            new Position(100.8, 0.8)
        );
        $poly3 = new Polygon($outerPoly3, $holePoly3);

        $mp = new MultiPolygon($poly1, $poly2, $poly3);

        $result = $mp->getPolygonPositions();

        $expected = [
            [
                $poly1->getOuterPositions()
            ],
            [
                $poly2->getOuterPositions()
            ],
            $poly3->getPositions()
        ];

        self::assertIsArray($result);
        self::assertCount(3, $result);
        self::assertEquals($expected, $result);
    }
}
