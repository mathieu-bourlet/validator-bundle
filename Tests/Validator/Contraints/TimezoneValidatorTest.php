<?php

namespace AssoConnect\ValidatorBundle\Tests\Validator\Constraints;

use AssoConnect\ValidatorBundle\Validator\Constraints\Timezone;
use AssoConnect\ValidatorBundle\Validator\Constraints\TimezoneValidator;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Test\ConstraintValidatorTestCase;

class TimezoneValidatorTest extends ConstraintValidatorTestCase
{
    protected function createValidator()
    {
        return new TimezoneValidator();
    }

    public function testInvalidConstraint()
    {
        $this->expectException(UnexpectedTypeException::class);
        $this->validator->validate(null, $this->createMock(Constraint::class));
    }

    /**
     * @var $timezone
     *
     * @dataProvider getValidTimezones
     */
    public function testValidTimezones($timezone)
    {
        $this->validator->validate($timezone, new Timezone());

        $this->assertNoViolation();
    }

    public function getValidTimezones()
    {
        return [
            [null],
            [''],
            ['Europe/Paris'],
            ['Europe/Berlin'],
        ];
    }

    /**
     * @var $timezone
     *
     * @dataProvider getInvalidTimezones
     */
    public function testInvalidTimezones($timezone)
    {
        $constraint = new Timezone(array(
            'message' => 'myMessage',
        ));

        $this->validator->validate($timezone, $constraint);

        $this->buildViolation('myMessage')
            ->setParameter('{{ value }}', '"' . $timezone . '"')
            ->setCode(Timezone::NO_SUCH_TIMEZONE_ERROR)
            ->assertRaised()
        ;
    }

    public function getInvalidTimezones()
    {
        return [
            ['EN'],
            ['foobar'],
        ];
    }
}
