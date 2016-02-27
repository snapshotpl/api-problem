<?php

namespace Snapshotpl\ApiProblemTest;

use Exception;
use PHPUnit_Framework_TestCase;
use Snapshotpl\ApiProblem\ApiProblem;
use Snapshotpl\ApiProblem\Exception\ApiProblemException;
use Zend\Diactoros\Uri;

/**
 * ApiProblemNamedConstructedTest
 *
 * @author Witold Wasiczko <witold@wasiczko.pl>
 */
class ApiProblemNamedConstructedTest extends PHPUnit_Framework_TestCase
{
    public function testCreateFromStatusCode()
    {
        $apiProblem = ApiProblem::createFromScalar(400, 'boo');

        $this->assertApiProblem($apiProblem, [
            'title' => 'Bad Request',
            'status' => 400,
            'detail' => 'boo',
            'type' => 'http://www.w3.org/Protocols/rfc2616/rfc2616-sec10.html',
        ]);
    }

    public function testCreateFromException()
    {
        $exception = new Exception('Message', 400);

        $apiProblem = ApiProblem::createFromException($exception);

        $this->assertApiProblem($apiProblem, [
            'title' => 'Internal Server Error',
            'status' => 500,
            'detail' => 'Unexpected error',
            'type' => 'http://www.w3.org/Protocols/rfc2616/rfc2616-sec10.html',
        ]);
    }

    public function testCreateFromApiProblemException()
    {
        $apiProblem = ApiProblem::createFromScalar(404, 'Entity not found');

        $exception = new ApiProblemException($apiProblem);

        $apiProblem = ApiProblem::createFromException($exception);

        $this->assertApiProblem($apiProblem, [
            'title' => 'Not Found',
            'status' => 404,
            'detail' => 'Entity not found',
            'type' => 'http://www.w3.org/Protocols/rfc2616/rfc2616-sec10.html',
        ]);
    }

    protected function assertApiProblem($apiProblem, array $details)
    {
        $this->assertInstanceOf(ApiProblem::class, $apiProblem);
        $this->assertSame($details, $apiProblem->getDetails());
    }
}
