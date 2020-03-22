<?php

namespace AssoConnect\ValidatorBundle\Tests\Validator\Constraints;

use AssoConnect\ValidatorBundle\Tests\ConstraintValidatorWithKernelTestCase;
use AssoConnect\ValidatorBundle\Validator\Constraints\Latitude;
use Symfony\Component\Validator\Constraints\GreaterThanOrEqual;
use Symfony\Component\Validator\Constraints\LessThanOrEqual;
use Symfony\Component\Validator\Constraints\Type;

final class LatitudeValidatorTest extends ConstraintValidatorWithKernelTestCase
{
    /**
     * @param $value
     *
     * @dataProvider providerValidValue
     */
    public function testItHandleValidValue($value)
    {
        $errors = $this->validator->validate($value, new Latitude());

        $this->assertCount(0, $errors);
    }

    public function providerValidValue(): array
    {
        return [
            [null],
            [-90.0],
            [0],
            [90.0],
        ];
    }

    /**
     * @param $value
     * @param $code
     *
     * @dataProvider providerInvalidValue
     */
    public function testItHandleInvalidValue($value, $code)
    {
        $errors = $this->validator->validate($value, new Latitude());

        $this->assertCount(1, $errors);
        $this->assertEquals($code, $errors[0]->getCode());
    }

    public function providerInvalidValue(): array
    {
        return [
            // Value type
            ['', Type::INVALID_TYPE_ERROR],
            // Default range
            [-91.0, GreaterThanOrEqual::TOO_LOW_ERROR],
            [91.0, LessThanOrEqual::TOO_HIGH_ERROR],
        ];
    }
}
