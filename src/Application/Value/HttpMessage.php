<?php
declare(strict_types=1);

namespace Darrigo\MovieCatalog\Application\Value;

/**
 * Class HttpMessage
 * @package Darrigo\MovieCatalog\Application\Value
 */
final class HttpMessage
{
    /**
     * @var int $status
     */
    private $statusCode;

    /**
     * @var string $message
     */
    private $message;

    /**
     * HttpMessage constructor.
     * @param int $statusCode
     * @param string $message
     */
    public function __construct(int $statusCode, string $message)
    {
        $this->statusCode = $statusCode;
        $this->message = $message;
    }

    /**
     * @return int
     */
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'status_code' => $this->statusCode,
            'message' => $this->message
        ];
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return json_encode($this->toArray());
    }
}
