<?php

namespace BcNum;

use BcNum\Exception\InvalidScaleErrorException;

class BcScale
{
    protected function __construct(private int $scale)
    {
    }

    /**
     * @throws InvalidScaleErrorException
     */
    public static function new(int $scale): self
    {
        if ($scale < 0 || $scale > 2147483647) {
            throw new InvalidScaleErrorException($scale);
        }
        return new BcScale($scale);
    }

    public static function getGlobal(): self
    {
        return new BcScale(bcscale(null));
    }

    public static function setGlobal(self $scale): void
    {
        bcscale($scale->getValue());
    }

    public function getValue(): int
    {
        return $this->scale;
    }
}
