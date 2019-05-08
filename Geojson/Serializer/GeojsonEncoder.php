<?php

/*
 * This file is part of the Geojson package.
 *
 * (c) Sebastian Kuhlmann <zebba@hotmail.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Alameda\Geojson\Serializer;

use Alameda\Geojson\Exception\UnsupportedTypeException;
use Alameda\Geojson\LineString;
use Alameda\Geojson\MultiLineString;
use Alameda\Geojson\MultiPoint;
use Alameda\Geojson\MultiPolygon;
use Alameda\Geojson\Point;
use Alameda\Geojson\Polygon;
use Symfony\Component\Serializer\Encoder\EncoderInterface;

/**
 * Transforms an array into Geojson objects
 *
 * @author Sebastian Kuhlmann <zebba@hotmail.de>
 * @package Alameda\Geojson\Serializer
 */
class GeojsonEncoder implements EncoderInterface
{
    /** @var string[] */
    private const KNOWN_TYPES = [
        'Point',
        'LineString',
        'Polygon',
        'MultiPoint',
        'MultiLineString',
        'MultiPolygon',
        'GeometryCollection',
        'FeatureCollection',
    ];

    /** @inheritDoc */
    public function encode($data, $format, array $context = array())
    {
        $data = json_decode($data, true);

        if (!array_key_exists('type', $data) || !in_array($data['type'], self::KNOWN_TYPES)) {
            throw UnsupportedTypeException::unknown($data['type']);
        }

        switch ($data['type']) {
            case 'Point':
                return Point::fromArray($data['coordinates']);
            case 'LineString':
                return LineString::fromArray($data['coordinates']);
            case 'Polygon':
                return Polygon::fromArray(...$data['coordinates']);
            case 'MultiPoint':
                return MultiPoint::fromArray($data['coordinates']);
            case 'MultiLineString':
                return MultiLineString::fromArray($data['coordinates']);
            case 'MultiPolygon':
                return MultiPolygon::fromArray($data['coordinates']);
            case 'GeometryCollection':
            case 'FeatureCollection':
                throw UnsupportedTypeException::notImplemented($data['type']);
        }
    }

    /** @inheritDoc */
    public function supportsEncoding($format)
    {
        return 'geojson' === $format;
    }
}
