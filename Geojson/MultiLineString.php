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
class MultiLineString
{
    /** @var LineString[] */
    private $lineStrings = [];

    /**
     * @param LineString[] ..$lineStrings
     */
    public function __construct(LineString ...$lineStrings)
    {
        $this->lineStrings = $lineStrings;
    }

    /**
     * @param array $a
     * @return MultiLineString
     */
    public static function fromArray(array $a)
    {
        $l = array_map(function (array $e) {
            return LineString::fromArray($e);
        }, $a);

        return new self(...$l);
    }

    /**
     * @return LineString[]
     */
    public function getLineStrings(): array
    {
        return $this->lineStrings;
    }

    /**
     * @return array:Position[]
     */
    public function getPositions(): array
    {
        return array_map(function (LineString $l) {
            return $l->getPositions();
        }, $this->lineStrings);
    }

    /**
     * @return array:float[]
     */
    public function toArray(): array
    {
        return array_map(function (LineString $l) {
            return $l->toArray();
        }, $this->lineStrings);
    }
}
