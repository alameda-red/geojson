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
class MultiPoint
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
     * @param array $a
     * @return MultiPoint
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
     * @return array:float[]
     */
    public function toArray(): array
    {
        return array_map(function (Position $p) {
            return $p->toArray();
        }, $this->positions);
    }
}
