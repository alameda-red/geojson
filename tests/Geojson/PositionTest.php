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

use Alameda\Geojson\Position;
use PHPUnit\Framework\TestCase;

/**
 * @author Sebastian Kuhlmann <zebba@hotmail.de>
 * @package Tests\Alameda\Geojson
 */
class PositionTest extends TestCase
{
    public function test()
    {
        $pos = new Position(123.45, -234.56);

        self::assertEquals(123.45, $pos->getLongitude());
        self::assertEquals(-234.56, $pos->getLatitude());
        self::assertEquals(0., $pos->getAltitude());
    }

    /** @dataProvider dataProviderToArray */
    public function testToArray(float $longitude, float $latitude, float $altitude, array $output)
    {
        $pos = new Position($longitude, $latitude, $altitude);

        $result = $pos->toArray();

        self::assertIsArray($result);
        self::assertEquals($output, $result);
    }

    public function dataProviderToArray()
    {
        yield [123.45, 234.56, 10., [123.45, 234.56, 10.]];
        yield [-123.45, 234.56, 10., [-123.45, 234.56, 10.]];
        yield [123.45, 234.56, -10., [123.45, 234.56, -10.]];
    }
}
