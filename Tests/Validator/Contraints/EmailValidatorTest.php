<?php

namespace AssoConnect\ValidatorBundle\Tests\Validator\Constraints;

use AssoConnect\ValidatorBundle\Validator\Constraints\Email;
use AssoConnect\ValidatorBundle\Validator\Constraints\EmailValidator;
use Pdp\Cache;
use Pdp\CurlHttpClient;
use Pdp\Manager;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Test\ConstraintValidatorTestCase;

final class EmailValidatorTest extends ConstraintValidatorTestCase
{
    public function createValidator(): EmailValidator
    {
        $manager = new Manager(new Cache(), new CurlHttpClient());

        return new EmailValidator($manager);
    }

    public function testInvalidConstraint()
    {
        $this->expectException(UnexpectedTypeException::class);
        $this->validator->validate(null, $this->createMock(Constraint::class));
    }

    /**
     * @var $value
     *
     * @dataProvider providerValidValues
     */
    public function testValidValues($value)
    {
        $this->validator->validate($value, new Email());
        $this->assertNoViolation();
    }

    public function providerValidValues()
    {
        return [
            [null],
            [''],
            ['valid@mail.com'],
            ['valid.valid@mail.com'],
            ['valid+valid@mail.com'],
            ['valid+valid@gmail.com'],
        ];
    }

    /**
     * @param $value
     * @param $messageField
     * @param $code
     *
     * @dataProvider providerInvalidValues
     */
    public function testInvalidValues($value, $messageField, $code)
    {
        $this->validator->validate($value, new Email([
            $messageField => 'testMessage',
        ]));

        $this
            ->buildViolation('testMessage')
            ->setParameter('{{ value }}', '"' . $value . '"')
            ->setCode($code)
            ->assertRaised()
        ;
    }

    public function providerInvalidValues()
    {
        return [
            // Format
            // #0
            [
                'format',
                'message',
                Email::INVALID_FORMAT_ERROR,
            ],
            // #1
            [
                'format;format@mail.com',
                'message',
                Email::INVALID_FORMAT_ERROR,
            ],
            // #2
            [
                'mailto:format@mail.com',
                'message',
                Email::INVALID_FORMAT_ERROR,
            ],
            // #3
            [
                ' format@mail.com',
                'message',
                Email::INVALID_FORMAT_ERROR,
            ],
            // #4
            [
                'format@mail.com ',
                'message',
                Email::INVALID_FORMAT_ERROR,
            ],
            // #5
            [
                'format@mail.com.',
                'message',
                Email::INVALID_FORMAT_ERROR,
            ],
            // #6 TLD
            [
                'tld@mail.error',
                'TLDMessage',
                Email::INVALID_TLD_ERROR,
            ],
        ];
    }
}
