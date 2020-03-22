<?php

namespace AssoConnect\ValidatorBundle\Tests\Validator\Constraints;

use AssoConnect\ValidatorBundle\Validator\Constraints\FloatScale;
use AssoConnect\ValidatorBundle\Validator\Constraints\FloatScaleValidator;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Test\ConstraintValidatorTestCase;

final class FloatScaleValidatorTest extends ConstraintValidatorTestCase
{
    protected function createValidator()
    {
        return new FloatScaleValidator();
    }

    public function testInvalidConstraint()
    {
        $this->expectException(UnexpectedTypeException::class);
        $this->validator->validate(null, $this->createMock(Constraint::class));
    }

    /**
     * @param $value
     * @param $scale
     *
     * @dataProvider providerValidValue
     */
    public function testItHandleValidValue($value, int $scale)
    {
        $constraint = new FloatScale($scale);

        $this->validator->validate($value, $constraint);
        $this->assertNoViolation();
    }

    public function providerValidValue(): array
    {
        return [
            [null, 0],
            [0, 0],
            ['', 0],
            [1.1, 1],
            [1.01, 2],
        ];
    }

    /**
     * @param $value
     * @param int $scale
     * @param string $code
     *
     * @dataProvider providerInvalidValue
     */
    public function testItHandleInvalidValue($value, int $scale, string $code)
    {
        $constraint = new FloatScale([
            'scale' => $scale,
            'message' => 'testMessage',
        ]);

        $this->validator->validate($value, $constraint);

        $this->buildViolation('testMessage')
            ->setParameter('{{ value }}', (string) $value)
            ->setParameter('{{ scale }}', (string) $scale)
            ->setCode($code)
            ->assertRaised()
        ;
    }

    public function providerInvalidValue(): array
    {
        return [
            [1.001, 2, FloatScale::TOO_PRECISE_ERROR],
        ];
    }
}
