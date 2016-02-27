<?php

namespace Snapshotpl\ApiProblem\Response;

use Psr\Http\Message\ResponseInterface;
use Snapshotpl\ApiProblem\ApiProblem;

/**
 * @author Witold Wasiczko <witold@wasiczko.pl>
 */
interface ApiProblemResponseFactoryInterface
{
    /**
     * @return ResponseInterface
     */
    public function createResponse(ApiProblem $apiProblem);
}
