<?php

/*
 * This file is part of the Geojson package.
 *
 * (c) Sebastian Kuhlmann <zebba@hotmail.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tests\Alameda\Geojson\Serializer;

use Alameda\Geojson\LineString;
use Alameda\Geojson\MultiLineString;
use Alameda\Geojson\MultiPoint;
use Alameda\Geojson\MultiPolygon;
use Alameda\Geojson\Point;
use Alameda\Geojson\Polygon;
use Alameda\Geojson\Position;
use Alameda\Geojson\Serializer\GeojsonEncoder;
use PHPUnit\Framework\TestCase;

/**
 * @author Sebastian Kuhlmann <zebba@hotmail.de>
 * @package Tests\Alameda\Geojson\Serializer
 */
class GeojsonEncoderTest extends TestCase
{
    private const POINT = __DIR__ . '/../../fixtures/point.geojson';
    private const LINESTRING = __DIR__ . '/../../fixtures/line_string.geojson';
    private const POLYGON = __DIR__ . '/../../fixtures/polygon.geojson';
    private const POLYGON_WITH_HOLES = __DIR__ . '/../../fixtures/polygon_with_holes.geojson';
    private const MULTI_POINT = __DIR__ . '/../../fixtures/multi_point.geojson';
    private const MULTI_LINESTRING = __DIR__ . '/../../fixtures/multi_line_string.geojson';
    private const MULTI_POLYGON = __DIR__ . '/../../fixtures/multi_polygon.geojson';
    private const MULTI_POLYGON_WITH_HOLES = __DIR__ . '/../../fixtures/multi_polygon_with_holes.geojson';
    private const MULTI_POLYGON_WITH_MULTI_HOLES = __DIR__ . '/../../fixtures/multi_polygon_multi_holes.geojson';


    /** @dataProvider fixtures */
    public function test(string $filepath, string $expectedClass)
    {
        $encoder = new GeojsonEncoder();
        $geojson = file_get_contents($filepath);

        $result = $encoder->encode($geojson, 'geojson');

        self::assertInstanceOf($expectedClass, $result);
    }

    public function testPoint()
    {
        $encoder = new GeojsonEncoder();
        $geojson = file_get_contents(self::POINT);

        /** @var Point $result */
        $result = $encoder->encode($geojson, 'geojson');
        $position = $result->getPositions();
        $position = $position[0];
        self::assertTrue($position->equals(new Position(100, 0)));
    }

    public function fixtures()
    {
        return [
            'point' => [
                self::POINT,
                Point::class
            ],
            'linestring' => [
                self::LINESTRING,
                LineString::class
            ],
            'polygon' => [
                self::POLYGON,
                Polygon::class
            ],
            'polygon with holes' => [
                self::POLYGON_WITH_HOLES,
                Polygon::class
            ],
            'multi point' => [
                self::MULTI_POINT,
                MultiPoint::class
            ],
            'multi linestring' => [
                self::MULTI_LINESTRING,
                MultiLineString::class
            ],
            'multi polygon' => [
                self::MULTI_POLYGON,
                MultiPolygon::class
            ],
            'multi polygon with holes' => [
                self::MULTI_POLYGON_WITH_HOLES,
                MultiPolygon::class
            ],
            'multi polygon with multi holes' => [
                self::MULTI_POLYGON_WITH_MULTI_HOLES,
                MultiPolygon::class
            ],

        ];
    }
}
