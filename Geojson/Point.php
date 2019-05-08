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
 * A Point is a value-object for a geometry comprising of a single coordinate.
 *
 * @author Sebastian Kuhlmann <zebba@hotmail.de>
 * @package Alameda\Geojson
 */
class Point
{
    /** @var Position */
    private $position;

    /**
     * @param Position $position
     */
    public function __construct(Position $position)
    {
        $this->position = $position;
    }

    /**
     * @example Point::fromArray([1, 2])
     * @example Point::fromArray([1, 2, 3])
     * @param float[] $a
     * @return Point
     */
    public static function fromArray(array $a): Point
    {
        return new self(Position::fromArray($a));
    }

    /**
     * @return Position[]
     */
    public function getPositions(): array
    {
        return [$this->position];
    }

    /**
     * Returns an array of floats representing the Position of the Point.
     *
     * @example new Point(new Position(1, 2)) => [1, 2, 0]
     * @example new Point(new Position(1, 2)) => [1, 2, 0]
     * @return float[]
     */
    public function toArray(): array
    {
        return $this->position->toArray();
    }
}
