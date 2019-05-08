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

use Symfony\Component\Serializer\Exception\UnexpectedValueException;

/**
 * @author Sebastian Kuhlmann <zebba@hotmail.de>
 * @package Alameda\Geojson\Exception
 */
class UnsupportedTypeException extends UnexpectedValueException
{
    const NOT_IMPLEMENTED = 1;
    const UNKNOWN = 2;

    /**
     * @param string $type
     * @param \Throwable|null $previous
     * @return UnsupportedTypeException
     */
    public static function notImplemented(string $type, \Throwable $previous = null): UnsupportedTypeException
    {
        return new self(
            sprintf('Encoding data for type \'%s\' is not supported yet', $type),
            self::NOT_IMPLEMENTED,
            $previous
        );
    }

    /**
     * @param string $type
     * @param \Throwable|null $previous
     * @return UnsupportedTypeException
     */
    public static function unknown(string $type, \Throwable $previous = null): UnsupportedTypeException
    {
        return new self(
            sprintf('Data of type \'%s\' is unknown', $type),
            self::UNKNOWN,
            $previous
        );
    }
}
