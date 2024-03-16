<?php

namespace BcNum;

use BcNum\Exception\DivisionByZeroErrorException;
use BcNum\Exception\InvalidNumberErrorException;
use Stringable;

class BcNum implements Stringable
{
    protected function __construct(private string $num)
    {
    }

    /**
     * @throws InvalidNumberErrorException
     */
    public static function new(string $num): self
    {
        if (!preg_match('/^-?\d+(\.\d+)?$/', $num)) {
            throw new InvalidNumberErrorException($num);
        }
        return new static($num);
    }

    public static function getGlobalScale(): BcScale
    {
        return BcScale::getGlobal();
    }

    public static function setGlobalScale(BcScale $scale): void
    {
        BcScale::setGlobal($scale);
    }

    public static function newScale(int $scale): BcScale
    {
        return BcScale::new($scale);
    }

    public function getValue(): string
    {
        return $this->num;
    }

    public function __toString(): string
    {
        return $this->getValue();
    }

    public function add(self $num, ?BcScale $scale = null): self
    {
        return new BcNum(bcadd($this->getValue(), $num->getValue()), $scale?->getValue());
    }

    public function sub(self $num, ?BcScale $scale = null): self
    {
        return new BcNum(bcsub($this->getValue(), $num->getValue()), $scale?->getValue());
    }

    public function mul(self $num, ?BcScale $scale = null): self
    {
        return new BcNum(bcmul($this->getValue(), $num->getValue()), $scale?->getValue());
    }

    /**
     * @throws DivisionByZeroErrorException
     */
    public function div(self $num, ?BcScale $scale = null): self
    {
        if ($num->isZero()) {
            throw new DivisionByZeroErrorException();
        }
        return new BcNum(bcdiv($this->getValue(), $num->getValue()), $scale?->getValue());
    }

    public function pow(self $exponent, ?BcScale $scale = null): self
    {
        return new BcNum(bcpow($this->getValue(), $exponent->getValue(), $scale?->getValue()));
    }

    public function sqrt(?BcScale $scale = null): self
    {
        return new BcNum(bcsqrt($this->getValue(), $scale?->getValue()));
    }

    /**
     * @throws DivisionByZeroErrorException
     */
    public function mod(self $num, ?BcScale $scale = null): self
    {
        if ($num->isZero()) {
            throw new DivisionByZeroErrorException();
        }
        return new BcNum(bcmod($this->getValue(), $num->getValue(), $scale?->getValue()));
    }

    public function comp(self $num, ?BcScale $scale = null): int
    {
        return bccomp($this->getValue(), $num->getValue(), $scale?->getValue());
    }

    /**
     * @throws DivisionByZeroErrorException
     */
    public function powMod(self $exponent, self $modulus, ?BcScale $scale = null): self
    {
        if ($modulus->isZero()) {
            throw new DivisionByZeroErrorException();
        }
        return new BcNum(bcpowmod($this->getValue(), $exponent->getValue(), $modulus->getValue()), $scale?->getValue());
    }

    public function abs(): self
    {
        if ($this->getValue()[0] === '-') {
            return new BcNum(substr($this->getValue(), 1));
        }
        return new BcNum($this->getValue());
    }

    public function neg(): self
    {
        if ($this->getValue()[0] === '-') {
            return new BcNum(substr($this->getValue(), 1));
        }
        if ($this->isZero()) {
            return new BcNum('0');
        }
        return new BcNum('-' . $this->getValue());
    }

    public function isZero(): bool
    {
        return $this->getValue() === '0';
    }

    public function isPositive(): bool
    {
        return $this->getValue()[0] !== '-' && !$this->isZero();
    }

    public function isNegative(): bool
    {
        return $this->getValue()[0] === '-';
    }

    public function eq(self $num, ?BcScale $scale = null): bool
    {
        return $this->comp($num, $scale) === 0;
    }

    public function gt(self $num, ?BcScale $scale = null): bool
    {
        return $this->comp($num, $scale) === 1;
    }

    public function gte(self $num, ?BcScale $scale = null): bool
    {
        return $this->comp($num, $scale) >= 0;
    }

    public function lt(self $num, ?BcScale $scale = null): bool
    {
        return $this->comp($num, $scale) === -1;
    }

    public function lte(self $num, ?BcScale $scale = null): bool
    {
        return $this->comp($num, $scale) <= 0;
    }
}
