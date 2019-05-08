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
 * A LineString is a value-object holding the longitudes, latitudes and altitudes of row of coordinate.
 *
 * @author Sebastian Kuhlmann <zebba@hotmail.de>
 * @package Alameda\Geojson
 */
class LineString
{
    /** @var Position[] */
    private $positions = [];

    /**
     * @param Position[] ..$positions
     */
    public function __construct(Position ...$positions)
    {
        $this->positions = $positions;
    }

    /**
     * @example LineString::fromArray([[100.0, 0.0], [200.0, 10.0]])
     * @example LineString::fromArray([[100.0, 0.0, 50.], [200.0, 10.0, 100.]])
     * @param array:float[] $a
     * @return LineString
     */
    public static function fromArray(array $a)
    {
        $p = array_map(function (array $e) {
            return Position::fromArray($e);
        }, $a);

        return new self(...$p);
    }

    /**
     * @return Position[]
     */
    public function getPositions(): array
    {
        return $this->positions;
    }

    /**
     * @return bool
     */
    public function isClosed(): bool
    {
        $last = end($this->positions);
        $first = reset($this->positions);

        return $first->equals($last);
    }

    /**
     * @example new LineString(new Position(0, 0), new Position (10, 0)) => [[0, 0, 0], [10, 0, 0]]
     * @example new LineString(new Position(0, 0, 0), new Position (10, 0, 5)) => [[0, 0, 0], [10, 0, 5]]
     * @return array:float[]
     */
    public function toArray(): array
    {
        return array_map(function (Position $p) {
            return $p->toArray();
        }, $this->positions);
    }
}
