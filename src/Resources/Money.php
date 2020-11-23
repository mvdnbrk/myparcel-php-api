<?php

namespace Mvdnbrk\MyParcel\Resources;

class Money extends BaseResource
{
    /** @var int */
    protected $amount;

    /** @var string */
    protected $currency;

    public function __construct($attributes)
    {
        parent::__construct($attributes);
    }

    public function setAmountAttribute(int $value): void
    {
        $this->amount = $value;
    }

    public function setCurrencyAttribute(string $value): void
    {
        $this->currency = $value;
    }
}
