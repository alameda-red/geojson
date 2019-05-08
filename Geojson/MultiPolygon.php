<?php

/*
 * This file is part of the Geojson package.
 *
 * (c) Sebastian Kuhlmann <zebba@hotmail.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Alameda\Geojson;

/**
 * @author Sebastian Kuhlmann <zebba@hotmail.de>
 * @package Alameda\Geojson
 */
class MultiPolygon
{
    /** @var Polygon[] */
    private $polygons = [];

    /**
     * @param Polygon ...$polygons
     */
    public function __construct(Polygon ...$polygons)
    {
        $this->polygons = $polygons;
    }

    /**
     * @param array $a
     * @return MultiPolygon
     */
    public static function fromArray(array $a)
    {
        $p = array_map(function (array $e) {
            return Polygon::fromArray(...$e);
        }, $a);

        return new self(...$p);
    }

    /**
     * @return Polygon[]
     */
    public function getPolygons(): array
    {
        return $this->polygons;
    }

    /**
     * @return array:Positon[]
     */
    public function getPolygonPositions(): array
    {
        return array_map(function (Polygon $o) {
            $result = [
                $o->getOuterPositions()
            ];

            if ($o->hasHoles()) {
                $result = array_merge($result, $o->getHolePositions());
            }

            return $result;
        }, $this->polygons);
    }

    /**
     * @return array:Position[]
     */
    public function getPositions(): array
    {
        return array_map(function (Polygon $p) {
            return $p->getPositions();
        }, $this->polygons);
    }
}
