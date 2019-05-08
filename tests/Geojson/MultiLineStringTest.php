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
use Alameda\Geojson\MultiLineString;
use Alameda\Geojson\Position;
use PHPUnit\Framework\TestCase;

/**
 * @author Sebastian Kuhlmann <zebba@hotmail.de>
 * @package Tests\Alameda\Geojson
 */
class MultiLineStringTest extends TestCase
{
    public function testGetLineStrings()
    {
        $lineA = $this->prophesize(LineString::class);
        $lineB = $this->prophesize(LineString::class);

        $mline = new MultiLineString($lineA->reveal(), $lineB->reveal());

        $result = $mline->getLineStrings();

        self::assertIsArray($result);
        self::assertCount(2, $result);
        self::assertEquals([$lineA->reveal(), $lineB->reveal()], $result);
    }

    public function testGetCoordinates()
    {
        $posA1 = $this->prophesize(Position::class);
        $posA2 = $this->prophesize(Position::class);
        $posB1 = $this->prophesize(Position::class);
        $posB2 = $this->prophesize(Position::class);

        $lineA = $this->prophesize(LineString::class);
        $lineA->getPositions()->willReturn([$posA1->reveal(), $posA2->reveal()]);
        $lineB = $this->prophesize(LineString::class);
        $lineB->getPositions()->willReturn([$posB1->reveal(), $posB2->reveal()]);

        $mline = new MultiLineString($lineA->reveal(), $lineB->reveal());

        $result = $mline->getPositions();

        self::assertIsArray($result);
        self::assertCount(2, $result);
        self::assertEquals([[$posA1->reveal(), $posA2->reveal()], [$posB1->reveal(), $posB2->reveal()]], $result);
    }
}
