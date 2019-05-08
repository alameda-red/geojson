<?php

/*
 * This file is part of the Geojson package.
 *
 * (c) Sebastian Kuhlmann <zebba@hotmail.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Alameda\Geojson\Exception;

use Alameda\Geojson\LineString;

/**
 * @author Sebastian Kuhlmann <zebba@hotmail.de>
 * @package Alameda\Geojson\Exception
 */
class NotClosedLineStringException extends \InvalidArgumentException
{
    const OUTER = 1;
    const HOLE = 2;

    /** @var LineString */
    private $geometry;

    /**
     * @param LineString $geometry
     * @param string $message
     * @param int $code
     * @param \Throwable|null $previous
     */
    public function __construct(LineString $geometry, $message = '', $code = 0, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);

        $this->geometry = $geometry;
    }


    /**
     * @param LineString $outer
     * @param \Throwable|null $previous
     * @return NotClosedLineStringException
     */
    public static function outer(LineString $outer, \Throwable $previous = null): NotClosedLineStringException
    {
        return new self(
            $outer,
            'The provided LineString is not closed',
            self::OUTER,
            $previous
        );
    }

    /**
     * @param LineString $hole
     * @param \Throwable|null $previous
     * @return NotClosedLineStringException
     */
    public static function hole(LineString $hole, \Throwable $previous = null): NotClosedLineStringException
    {
        return new self(
            $hole,
            'The provided LineString is not closed',
            self::HOLE,
            $previous
        );
    }

    /**
     * @return LineString
     */
    public function getGeometry(): LineString
    {
        return $this->geometry;
    }
}
