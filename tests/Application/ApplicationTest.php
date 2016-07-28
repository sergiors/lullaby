<?php

namespace Sergiors\Lullaby\Tests\Applicaiton;

use Sergiors\Lullaby\Tests\Fixtures\Apps\Test\Test;

class ApplicationTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function shouldRetrunName()
    {
        $app = new Test();
        $this->assertEquals('Test', $app->getName());
    }

    /**
     * @test
     */
    public function shouldRetrunNamespace()
    {
        $app = new Test();
        $this->assertEquals('Sergiors\Lullaby\Tests\Fixtures\Apps\Test', $app->getNamespace());
    }

    /**
     * @test
     */
    public function shouldRetrunPath()
    {
        $app = new Test();
        $path = dirname((new \ReflectionClass(Test::class))->getFileName());
        $this->assertEquals($path, $app->getPath());
    }
}
