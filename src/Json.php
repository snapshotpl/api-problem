<?php

namespace Snapshotpl\ApiProblem;

/**
 * Json
 *
 * @author Witold Wasiczko <witold@wasiczko.pl>
 */
class Json
{
    /**
     * @return string
     */
    public static function toJson(ApiProblem $apiProblem)
    {
        $details = $apiProblem->getDetails();

        return json_encode($details);
    }
}
