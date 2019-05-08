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
 * A Position is a value-object holding the longitude, latitude and altitude of a coordinate.
 *
 * @author Sebastian Kuhlmann <zebba@hotmail.de>
 * @package Alameda\Geojson
 */
class Position
{
    /** @var float */
    private $latitude;

    /** @var float */
    private $longitude;

    /** @var float */
    private $altitude;

    /**
     * @param float $longitude
     * @param float $latitude
     * @param float $altitude
     */
    public function __construct(float $longitude, float $latitude, float $altitude = 0)
    {
        $this->longitude = $longitude;
        $this->latitude = $latitude;
        $this->altitude = $altitude;
    }

    /**
     * @example Position::fromArray([1, 2])
     * @example Position::fromArray([1, 2, 3])
     * @param float[] $a
     * @return Position
     */
    public static function fromArray(array $a): Position
    {
        return new Position(...$a);
    }

    /**
     * @return float
     */
    public function getLongitude(): float
    {
        return $this->longitude;
    }

    /**
     * @return float
     */
    public function getLatitude(): float
    {
        return $this->latitude;
    }

    /**
     * @return float
     */
    public function getAltitude(): float
    {
        return $this->altitude;
    }

    /**
     * Returns an array of floats representing the Position. The order of the values is longitude, latitude, altitude.
     *
     * @example new Position(1, 2) => [1, 2, 0]
     * @example new Position(1, 2, 3) => [1, 2, 3]
     * @return float[]
     */
    public function toArray(): array
    {
        return [
            $this->longitude,
            $this->latitude,
            $this->altitude
        ];
    }

    /**
     * @param Position $position
     * @return bool
     */
    public function equals(Position $position): bool
    {
        return
            $this->getLongitude() === $position->getLongitude() &&
            $this->getLatitude() === $position->getLatitude() &&
            $this->getAltitude() === $position->getAltitude()
        ;
    }
}
