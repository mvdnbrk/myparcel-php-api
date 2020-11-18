<?php

namespace Mvdnbrk\MyParcel\Resources;

use Mvdnbrk\MyParcel\Types\DeliveryType;
use Mvdnbrk\MyParcel\Types\PackageType;

class ShipmentOptions extends BaseResource
{
    /** @var bool */
    public $age_check;

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

    /** @var array|null */
    public $insurance;

    public function __construct(array $attributes = [])
    {
        $this->setDefaultOptions();

        parent::__construct($attributes);
    }

    public function setDefaultOptions(): self
    {
        $this->age_check = false;
        $this->return = false;
        $this->signature = false;
        $this->large_format = false;
        $this->package_type = PackageType::PACKAGE;
        $this->delivery_type = DeliveryType::STANDARD;
        $this->only_recipient = false;

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

    /**
     * Set Insurance amount. Only applicable for package_type = 1 (package)
     * @param int $value
     * @return $this
     */
    public function setInsurance(int $value, string $currency = 'EUR')
    {
        if ($this->package_type === 1) {
            $this->insurance = [
                'amount' => $value,
                'currency' => $currency
            ];
        }
        return $this;
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
