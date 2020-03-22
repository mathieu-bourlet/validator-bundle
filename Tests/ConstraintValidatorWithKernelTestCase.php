<?php

namespace AssoConnect\ValidatorBundle\Tests;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Validator\Validator\ValidatorInterface;

abstract class ConstraintValidatorWithKernelTestCase extends KernelTestCase
{
    /** @var ValidatorInterface */
    protected $validator;

    public static function setUpBeforeClass()
    {
        $fs = new Filesystem();
        $fs->remove(sys_get_temp_dir() . '/AssoConnectValidatorBundle/');
    }

    protected static function getKernelClass()
    {
        return TestKernel::class;
    }

    public function setUp()
    {
        self::bootKernel();

        $this->validator = self::$kernel->getContainer()->get('validator');
    }
}
