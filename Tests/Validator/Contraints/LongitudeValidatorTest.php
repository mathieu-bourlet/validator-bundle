<?php

namespace AssoConnect\ValidatorBundle\Tests\Validator\Constraints;

use AssoConnect\ValidatorBundle\Tests\ConstraintValidatorWithKernelTestCase;
use AssoConnect\ValidatorBundle\Validator\Constraints\Longitude;
use Symfony\Component\Validator\Constraints\GreaterThanOrEqual;
use Symfony\Component\Validator\Constraints\LessThanOrEqual;
use Symfony\Component\Validator\Constraints\Type;

final class LongitudeValidatorTest extends ConstraintValidatorWithKernelTestCase
{
    /**
     * @param $value
     *
     * @dataProvider providerValidValue
     */
    public function testValidValue($value)
    {
        $errors = $this->validator->validate($value, new Longitude());

        $this->assertCount(0, $errors);
    }

    public function providerValidValue(): array
    {
        return [
            [null],
            [-180.0],
            [0],
            [180.0],
        ];
    }

    /**
     * @param $value
     * @param $code
     *
     * @dataProvider providerInvalidValue
     */
    public function testInvalidValue($value, $code)
    {
        $errors = $this->validator->validate($value, new Longitude());

        $this->assertCount(1, $errors);
        $this->assertEquals($code, $errors[0]->getCode());
    }

    public function providerInvalidValue(): array
    {
        return [
            // Value type
            ['', Type::INVALID_TYPE_ERROR],
            // Default range
            [-181.0, GreaterThanOrEqual::TOO_LOW_ERROR],
            [181.0, LessThanOrEqual::TOO_HIGH_ERROR],
        ];
    }
}
