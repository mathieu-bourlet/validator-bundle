<?php

namespace AssoConnect\ValidatorBundle\Tests;

use AssoConnect\ValidatorBundle\AssoConnectValidatorBundle;
use Symfony\Bundle\FrameworkBundle\FrameworkBundle;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\HttpKernel\Kernel;

final class TestKernel extends Kernel
{
    public function registerBundles()
    {
        return [
            new FrameworkBundle(),
            new AssoConnectValidatorBundle(),
        ];
    }

    public function __construct($environment, $debug)
    {
        parent::__construct($environment, $debug);
    }

    public function getCacheDir()
    {
        return $this->basePath() . 'cache/' . $this->environment;
    }

    public function getLogDir()
    {
        return $this->basePath() . 'logs';
    }

    private function basePath()
    {
        return sys_get_temp_dir() . '/AssoConnectValidatorBundle/' . Kernel::VERSION . '/';
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
    }
}
