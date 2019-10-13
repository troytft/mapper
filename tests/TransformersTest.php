<?php

namespace Tests;

use Mapper;
use PHPUnit\Framework\TestCase;

class TransformersTest extends TestCase
{
    public function testDateTimeFormatOption()
    {
        $transformer = new Mapper\Transformer\DateTimeTransformer();
        $options = [
            Mapper\Transformer\DateTimeTransformer::FORMAT_OPTION_NAME => 'Y-m-d-H:i:sP'
        ];

        // invalid date format
        try {
            $transformer->transform('2021-10-01T16:00:00+00:00', $options);
            $this->fail();
        } catch (Mapper\Exception\Transformer\InvalidDateTimeFormatException $exception) {
            $this->assertSame('Y-m-d-H:i:sP', $exception->getFormat());
        }

        // success
        $value = $transformer->transform('2021-10-01-16:00:00+00:00', $options);
        $this->assertInstanceOf(\DateTime::class, $value);
    }

    public function testDateFormatOption()
    {
        $transformer = new Mapper\Transformer\DateTransformer();
        $options = [
            Mapper\Transformer\DateTransformer::FORMAT_OPTION_NAME => 'Y/m/d'
        ];

        // invalid date format
        try {
            $transformer->transform('2021-10-010', $options);
            $this->fail();
        } catch (Mapper\Exception\Transformer\InvalidDateFormatException $exception) {
            $this->assertSame('Y/m/d', $exception->getFormat());
        }

        // success
        $value = $transformer->transform('2021/10/01', $options);
        $this->assertInstanceOf(\DateTime::class, $value);
    }

    public function testDateTimeForceLocalTimezoneOption()
    {
        $transformer = new Mapper\Transformer\DateTimeTransformer();

        $datetime = new \DateTime();
        $timezone = new \DateTimeZone('Europe/Prague');
        $datetime->setTimezone($timezone);

        // false
        $options = [
            Mapper\Transformer\DateTimeTransformer::FORCE_LOCAL_TIMEZONE_OPTION_NAME => false
        ];

        $value = $transformer->transform('2021-10-01T16:00:00+03:00', $options);
        $this->assertSame('+03:00', $value->getTimezone()->getName());

        // true
        $options = [
            Mapper\Transformer\DateTimeTransformer::FORCE_LOCAL_TIMEZONE_OPTION_NAME => true
        ];

        $value = $transformer->transform('2021-10-01T16:00:00+03:00', $options);
        $this->assertSame('UTC', $value->getTimezone()->getName());
    }
}
