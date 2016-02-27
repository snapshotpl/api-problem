<?php

namespace Snapshotpl\ApiProblem\Response;

use Snapshotpl\ApiProblem\ApiProblem;
use Snapshotpl\ApiProblem\Json;
use Zend\Diactoros\Response;

/**
 * ApiProblemJsonResponseFactory
 *
 * @author Witold Wasiczko <witold@wasiczko.pl>
 */
final class ApiProblemJsonResponseFactory implements ApiProblemResponseFactoryInterface
{
    public function createResponse(ApiProblem $apiProblem)
    {
        $response =  new Response('php://memory', $apiProblem->getDetail('status'), [
            'Content-Type' => 'application/problem+json',
        ]);

        $json = Json::toJson($apiProblem);

        $response->getBody()->write($json);

        return $response;
    }
}
