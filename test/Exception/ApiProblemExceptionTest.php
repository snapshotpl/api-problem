<?php

namespace Snapshotpl\ApiProblemTest\Exception;

use PHPUnit_Framework_TestCase;
use Snapshotpl\ApiProblem\ApiProblem;
use Snapshotpl\ApiProblem\Exception\ApiProblemException;

/**
 * ApiProblemExceptionTest
 *
 * @author Witold Wasiczko <witold@wasiczko.pl>
 */
class ApiProblemExceptionTest extends PHPUnit_Framework_TestCase
{
    private $exception;


    protected function setUp()
    {
        $apiProblem = ApiProblem::createFromScalar(404, 'Boo');

        $prevException = new \LogicException('Not found entity');

        $this->exception = new ApiProblemException($apiProblem, $prevException);
    }

    public function testToString()
    {
        $string = (string) $this->exception;

        $this->assertContains('Not found entity', $string);
        $this->assertContains('404', $string);
        $this->assertContains(\LogicException::class, $string);
        $this->assertContains('Boo', $string);
    }
}
