<?php

namespace Snapshotpl\ApiProblemTest\Response;

use PHPUnit_Framework_TestCase;
use Psr\Http\Message\ResponseInterface;
use Snapshotpl\ApiProblem\ApiProblem;
use Snapshotpl\ApiProblem\Response\ApiProblemJsonResponseFactory;

/**
 * ApiProblemJsonResponseFactoryTest
 *
 * @author Witold Wasiczko <witold@wasiczko.pl>
 */
class ApiProblemJsonResponseFactoryTest extends PHPUnit_Framework_TestCase
{
    protected $factory;

    protected function setUp()
    {
        $this->factory = new ApiProblemJsonResponseFactory();
    }

    public function testCreate()
    {
        $apiProblem = ApiProblem::createFromScalar(400, 'You are wrong');

        $response = $this->factory->createResponse($apiProblem);

        $this->assertInstanceOf(ResponseInterface::class, $response);

        $this->assertSame('application/problem+json', $response->getHeaderLine('Content-type'));
        $this->assertSame(400, $response->getStatusCode());

        $json = '{"title":"Bad Request","status":400,"detail":"You are wrong","type":"http:\/\/www.w3.org\/Protocols\/rfc2616\/rfc2616-sec10.html"}';
        $this->assertSame($json, (string) $response->getBody());
    }
}
