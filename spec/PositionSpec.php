<?php

/*
 * This file is part of the Geojson package.
 *
 * (c) Sebastian Kuhlmann <zebba@hotmail.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\Alameda\Geojson;

use Alameda\Geojson\Position;
use PhpSpec\ObjectBehavior;

/**
 * @author Sebastian Kuhlmann <zebba@hotmail.de>
 * @package spec\Alameda\Geojson
 */
class PositionSpec extends ObjectBehavior
{
    function let()
    {
        $longitude = 543.21;
        $latitude = 123.45;
        $altitude = 10.;

        $this->beConstructedWith($longitude, $latitude, $altitude);
    }

    function it_is_initilizable()
    {
        $this->shouldHaveType(Position::class);
    }

    function it_can_be_generated_from_arrays()
    {
        $this::fromArray([100.0, 0.0]);
        $this::fromArray([100.0, 0.0, 50.]);
    }

    function it_has_coordinates()
    {
        $this->getLongitude()->shouldReturn(543.21);
        $this->getLatitude()->shouldReturn(123.45);
        $this->getAltitude()->shouldReturn(10.);
    }

    function it_is_transformable_to_array()
    {
        $this->toArray()->shouldReturn([543.21, 123.45, 10.]);
    }

    function it_should_transform_an_altitude_of_0()
    {
        $this->beConstructedWith(543.21, 123.45);

        $this->toArray()->shouldReturn([543.21, 123.45, 0.]);
    }

    function it_is_comparable()
    {
        $longitude = 543.21;
        $latitude = 123.45;
        $altitude = 10.;

        $this->equals(new Position($longitude, $latitude, $altitude))->shouldReturn(true);
        $this->equals(new Position($latitude, $altitude, $longitude))->shouldReturn(false);
    }
}
