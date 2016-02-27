<?php

namespace Snapshotpl\ApiProblem;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * ErrorHandler
 *
 * @author Witold Wasiczko <witold@wasiczko.pl>
 */
class ErrorHandler
{
    private $factory;

    public function __construct(Response\ApiProblemResponseFactoryInterface $factory)
    {
        $this->factory = $factory;
    }

    public function __invoke($error, ServerRequestInterface $request, ResponseInterface $response, callable $next)
    {
        if ($error instanceof \Exception) {
            $apiProblem = ApiProblem::createFromException($error);

            return $this->factory->createResponse($apiProblem);
        }
        return $next($error, $request, $response);
    }
}
