<?php

namespace Snapshotpl\ApiProblem;

use InvalidArgumentException;
use LogicException;
use Psr\Http\Message\UriInterface;
use Snapshotpl\StatusCode\StatusCode;

/**
 * ApiProblem
 *
 * @author Witold Wasiczko <witold@wasiczko.pl>
 */
class ApiProblem
{
    private $details = [];

    protected $protectedDetailsMap = [
        'type' => 'setType',
        'title' => 'setTitle',
        'status' => 'setStatus',
        'detail' => 'setDetail',
        'instance' => 'setInstance',
    ];

    /**
     * @param int $statusCode
     * @param string $detail
     *
     * @return \self
     */
    final public static function createFromScalar($statusCode, $detail)
    {
        $instance = new self();
        $instance->setStatusAndTitle(new StatusCode($statusCode));
        $instance->setDetail($detail);
        $instance->addDetailInternal('type', 'http://www.w3.org/Protocols/rfc2616/rfc2616-sec10.html');

        return $instance;
    }

    /**
     * @param \Exception $exception
     *
     * @return self
     */
    final public static function createFromException(\Exception $exception)
    {
        if ($exception instanceof Exception\ApiProblemExceptionInterface) {
            return $exception->getApiProblem();
        }

        return self::createFromScalar(500, 'Unexpected error');
    }

    final public function setType(UriInterface $type)
    {
        $this->addDetailInternal('type', (string) $type);
    }

    final public function setTypeNotPresented()
    {
        $this->addDetailInternal('type', 'about:blank');
    }

    final public function setTitle($title)
    {
        if (!is_string($title)) {
            throw new InvalidArgumentException('Title must be a string');
        }
        $this->addDetailInternal('title', $title);
    }

    final public function setStatus(StatusCode $status)
    {
        $this->addDetailInternal('status', $status->getStatusCode());
    }

    final public function setStatusAndTitle(StatusCode $status)
    {
        $this->setTitle($status->getReasonPhrase());
        $this->setStatus($status);
    }

    final public function setDetail($detail)
    {
        if (!is_string($detail)) {
            throw new InvalidArgumentException('Detail must be a string');
        }
        $this->addDetailInternal('detail', $detail);
    }

    final public function addDetails(array $details)
    {
        foreach ($details as $key => $value) {
            $this->addDetail($key, $value);
        }
    }

    final public function getDetail($detail)
    {
        if (!array_key_exists($detail, $this->details)) {
            throw new LogicException('Detail does not exist');
        }

        return $this->details[$detail];
    }

    final public function setInstance(UriInterface $instance)
    {
        $this->addDetailInternal('instance', (string) $instance);
    }

    final public function addDetail($key, $value)
    {
        if (isset($this->protectedDetailsMap[$key])) {
            $this->{$this->protectedDetailsMap[$key]}($value);
        } else {
            $this->addDetailInternal($key, $value);
        }
    }

    private function addDetailInternal($key, $value)
    {
        $this->details[$key] = $value;
    }

    final public function getDetails()
    {
        return $this->details;
    }
}
