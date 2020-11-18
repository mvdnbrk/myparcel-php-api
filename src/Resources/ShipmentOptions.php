<?php

namespace Mvdnbrk\MyParcel\Resources;

class ShipmentOptions extends BaseResource
{
    /** @var int */
    public $delivery_type;

    /** @var string */
    public $label_description;

    /** @var bool */
    public $large_format;

    /** @var bool */
    public $only_recipient;

    /** @var int */
    public $package_type;

    /** @var bool */
    public $return;

    /** @var bool */
    public $signature;

    /** @var boolean */
    public $age_check;

    public function __construct(array $attributes = [])
    {
        $this->setDefaultOptions();

        parent::__construct($attributes);
    }

    public function setDefaultOptions(): self
    {
        $this->return = false;
        $this->signature = false;
        $this->large_format = false;
        $this->package_type = 1;
        $this->delivery_type = 2;
        $this->only_recipient = false;
        $this->age_check = false;

        return $this;
    }

    public function getDescriptionAttribute(): string
    {
        return $this->label_description;
    }

    public function setDescriptionAttribute(string $value): void
    {
        $this->label_description = $value;
    }

    public function toArray(): array
    {
        return collect(parent::toArray())
            ->map(function ($value) {
                if (is_bool($value)) {
                    return (int) $value;
                }

                return $value;
            })
            ->all();
    }
}
