<?php

namespace AssoConnect\ValidatorBundle\Tests\Validator\Constraints;

use AssoConnect\ValidatorBundle\Tests\ConstraintValidatorWithKernelTestCase;
use AssoConnect\ValidatorBundle\Validator\Constraints\Money;
use Symfony\Component\Validator\Constraints\GreaterThanOrEqual;
use Symfony\Component\Validator\Constraints\LessThan;
use Symfony\Component\Validator\Constraints\Type;

final class MoneyValidatorTest extends ConstraintValidatorWithKernelTestCase
{
    /**
     * @param $value
     *
     * @dataProvider providerValidValue
     */
    public function testValidValue($value)
    {
        $errors = $this->validator->validate($value, new Money());

        $this->assertCount(0, $errors);
    }

    public function providerValidValue(): array
    {
        return [
            [null],
            [0.0],
            [0],
            [100.0],
            [Money::MAX - 0.1],
        ];
    }

    /**
     * @param $value
     * @param array $options
     * @param $code
     *
     * @dataProvider providerInvalidValue
     */
    public function testInvalidValue($value, array $options, $code)
    {
        $errors = $this->validator->validate($value, new Money($options));

        $this->assertCount(1, $errors);
        $this->assertEquals($code, $errors[0]->getCode());
    }

    public function providerInvalidValue(): array
    {
        return [
            // Value type
            ['', [], Type::INVALID_TYPE_ERROR],
            // Default range
            [-1.0, [], GreaterThanOrEqual::TOO_LOW_ERROR],
            [Money::MAX + 1, [], LessThan::TOO_HIGH_ERROR],
            // Custom range
            [0.0, ['min' => 10], GreaterThanOrEqual::TOO_LOW_ERROR],
            [11.0, ['max' => 10], LessThan::TOO_HIGH_ERROR],
        ];
    }
}
