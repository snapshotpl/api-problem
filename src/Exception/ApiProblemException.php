<?php

namespace Snapshotpl\ApiProblem\Exception;

use Exception;
use Snapshotpl\ApiProblem\ApiProblem;
use Snapshotpl\ApiProblem\Json;

/**
 * ApiProblemException
 *
 * @author Witold Wasiczko <witold@wasiczko.pl>
 */
class ApiProblemException extends Exception implements ApiProblemExceptionInterface
{
    private $apiProblem;

    public function __construct(ApiProblem $apiProblem, Exception $previous = null)
    {
        parent::__construct('', 0, $previous);

        $this->apiProblem = $apiProblem;
    }

    public function __toString()
    {
        $pattern = "ApiProblem exception '%s' with content '%s' in %s:%d\nStack trace:\n%s\nPrevious: %s";

        return vsprintf($pattern, [
            __CLASS__,
            Json::toJson($this->apiProblem),
            $this->getFile(),
            $this->getLine(),
            $this->getTraceAsString(),
            $this->getPrevious(),
        ]);
    }

    public function getApiProblem()
    {
        return $this->apiProblem;
    }
}
