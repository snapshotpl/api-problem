<?php

namespace Snapshotpl\ApiProblemTest;

use InvalidArgumentException;
use LogicException;
use PHPUnit_Framework_TestCase;
use Snapshotpl\ApiProblem\ApiProblem;
use Snapshotpl\StatusCode\StatusCode;
use Zend\Diactoros\Uri;

/**
 * ApiProblemTest
 *
 * @author Witold Wasiczko <witold@wasiczko.pl>
 */
class ApiProblemTest extends PHPUnit_Framework_TestCase
{
    protected $apiProblem;

    protected function setUp()
    {
        $this->apiProblem = new ApiProblem();
    }

    public function testEmptyDetails()
    {
        $this->assertDetails([]);
    }

    public function testSetOneDetail()
    {
        $this->apiProblem->addDetail('foo', 1);

        $this->assertDetails(['foo' => 1]);
    }

    public function testSetDetails()
    {
        $this->apiProblem->addDetails([
            'boo' => 'bar',
            'baz' => 'foo',
        ]);

        $this->assertDetails([
            'boo' => 'bar',
            'baz' => 'foo',
        ]);
    }

    public function testSetMultipeDetails()
    {
        $this->apiProblem->addDetail('foo', 1);
        $this->apiProblem->addDetail('bar', 'baz');

        $this->assertDetails(['foo' => 1, 'bar' => 'baz']);
    }

    public function testSetTypeNotPresented()
    {
        $this->apiProblem->setTypeNotPresented();

        $this->assertDetails(['type' => 'about:blank']);
    }

    public function testSetType()
    {
        $uri = new Uri('http://foobar.com');

        $this->apiProblem->setType($uri);

        $this->assertDetails(['type' => 'http://foobar.com']);
    }

    public function testSetTitle()
    {
        $this->apiProblem->setTitle('Boo');

        $this->assertDetails(['title' => 'Boo']);
    }

    public function testSetInvalidTitle()
    {
        $this->setExpectedException(InvalidArgumentException::class);

        $this->apiProblem->setTitle(1);
    }

    public function testSetStatus()
    {
        $statusCode = new StatusCode(400);

        $this->apiProblem->setStatus($statusCode);

        $this->assertDetails(['status' => 400]);
    }

    public function testSetStatusAndTitleByStatusCode()
    {
        $statusCode = new StatusCode(400);

        $this->apiProblem->setStatusAndTitle($statusCode);

        $this->assertDetails(['title' => 'Bad Request','status' => 400]);
    }

    public function testSetDetail()
    {
        $this->apiProblem->setDetail('Boo');

        $this->assertDetails(['detail' => 'Boo']);
    }

    public function testSetInvalidDetail()
    {
        $this->setExpectedException(InvalidArgumentException::class);

        $this->apiProblem->setDetail(1);
    }

    public function testInstance()
    {
        $uri = new Uri('http://foobar.com');

        $this->apiProblem->setInstance($uri);

        $this->assertDetails(['instance' => 'http://foobar.com']);
    }

    public function testTryToSetProtectedDetailObject()
    {
        $this->apiProblem->addDetail('status', new StatusCode(500));

        $this->assertDetails(['status' => 500]);
    }

    public function testGetDetail()
    {
        $this->apiProblem->addDetail('Boo', 'bar');

        $this->assertSame('bar', $this->apiProblem->getDetail('Boo'));
    }

    public function testGetNotExistingDetail()
    {
        $this->setExpectedException(LogicException::class);

        $this->apiProblem->getDetail('Boo');
    }

    public function testGetNullDetail()
    {
        $this->apiProblem->addDetail('null', null);

        $this->assertNull($this->apiProblem->getDetail('null'));
    }

    protected function assertDetails(array $detail)
    {
        $this->assertEquals($detail, $this->apiProblem->getDetails());
    }
}
