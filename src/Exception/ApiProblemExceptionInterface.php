<?php

namespace Snapshotpl\ApiProblem\Exception;

use Snapshotpl\ApiProblem\ApiProblem;

/**
 * @author Witold Wasiczko <witold@wasiczko.pl>
 */
interface ApiProblemExceptionInterface
{
    /**
     * @return ApiProblem
     */
    public function getApiProblem();
}
