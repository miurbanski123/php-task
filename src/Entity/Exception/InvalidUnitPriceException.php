<?php

declare(strict_types=1);

namespace Recruitment\Entity\Exception;

use Throwable;

class InvalidUnitPriceException extends \InvalidArgumentException
{
    /**
     * InvalidUnitPriceException constructor.
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct(string $message = "", int $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
