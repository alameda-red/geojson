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

use Alameda\Geojson\Exception\NotClosedLineStringException;

/**
 * @author Sebastian Kuhlmann <zebba@hotmail.de>
 * @package Alameda\Geojson
 */
class Polygon
{
    /** @var LineString */
    private $outer;

    /** @var LineString[] */
    private $holes = [];

    /**
     * @param LineString $outer
     * @param LineString[] ..$holes
     */
    public function __construct(LineString $outer, LineString ...$holes)
    {
        if (!$outer->isClosed()) {
            throw NotClosedLineStringException::outer($outer);
        }

        $allClosed = array_reduce($holes, function ($result, LineString $l) {
            if (!$l->isClosed()) {
                $result = $l;
            }

            return $result;
        }, true);

        if (true !== $allClosed) {
            throw NotClosedLineStringException::hole($allClosed);
        }

        $this->outer = $outer;
        $this->holes = $holes;
    }

    /**
     * @param array $outer
     * @param array ...$holes
     * @return Polygon
     */
    public static function fromArray(array $outer, array ...$holes)
    {
        $outer = LineString::fromArray($outer);

        if (!empty($holes)) {
            $holes = array_map(function (array $e) {
                return LineString::fromArray($e);
            }, $holes);

            return new self($outer, ...$holes);
        }

        return new self($outer);
    }

    /**
     * @return bool
     */
    public function hasHoles(): bool
    {
        return !empty($this->holes);
    }

    /**
     * @return LineString
     */
    public function getOuterLineString(): LineString
    {
        return $this->outer;
    }

    /**
     * @return LineString[]
     */
    public function getHoleLineStrings(): array
    {
        return $this->holes;
    }

    /**
     * @return Position[]
     */
    public function getOuterPositions(): array
    {
        return $this->outer->getPositions();
    }

    /**
     * @return array:Position[]
     */
    public function getHolePositions(): array
    {
        return array_map(function(LineString $l) {
            return $l->getPositions();
        }, $this->holes);
    }

    /**
     * @return array:float[]
     */
    public function toArray(): array
    {
        $result = [$this->outer->toArray()];

        if ($this->hasHoles()) {
            $result = array_merge($result, array_map(function (LineString $l) {
                return $l->toArray();
            }, $this->holes));
        }

        return $result;
    }

    /**
     * @return array:Position[]
     */
    public function getPositions(): array
    {
        $result = [$this->outer->getPositions()];

        if ($this->hasHoles()) {
            $result = array_merge($result, array_map(function (LineString $l) {
                return $l->getPositions();
            }, $this->holes));
        }

        return $result;
    }
}
