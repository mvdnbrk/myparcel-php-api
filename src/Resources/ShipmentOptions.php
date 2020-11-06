<?php

namespace Mvdnbrk\MyParcel\Resources;

use Carbon\Carbon;
use Mvdnbrk\MyParcel\Types\DeliveryType;
use Mvdnbrk\MyParcel\Types\PackageType;

class ShipmentOptions extends BaseResource
{
    /** @var int */
    public $delivery_type;

    /** @var int */
    public $package_type;

    /**
     * @var Carbon
     */
    public $delivery_date;

    /** @var string */
    public $label_description;

    /** @var bool */
    public $large_format;

    /** @var bool */
    public $only_recipient;

    /** @var bool */
    public $return;

    /** @var bool */
    public $signature;

    /** @var boolean */
    public $age_check;

    /** @var int */
    public $insurance;

    public function __construct(array $attributes = [])
    {
        $this->setDefaultOptions();

        parent::__construct($attributes);
    }

    public function setDefaultOptions(): self
    {
        $this->package_type = PackageType::PACKAGE;
        $this->delivery_type = DeliveryType::STANDARD;
        $this->return = false;
        $this->signature = false;
        $this->large_format = false;
        $this->only_recipient = false;
        $this->age_check = false;

        return $this;
    }

    public function getDescriptionAttribute(): string
    {
        return $this->label_description;
    }

    public function setDescriptionAttribute(string $value)
    {
        $this->label_description = $value;
    }

    /**
     * Get formatted delivery_date
     * @return string|null
     */
    public function getDeliveryDateAttribute()
    {
        return !is_null($this->delivery_date)
            ? $this->delivery_date->format("Y-m-d H:i:s")
            : null;
    }

    /**
     * Set Insurance amount. Only applicable for package_type = 1 (package)
     * @param int $value
     * @return $this
     */
    public function setInsuranceAttribute(int $value)
    {
        if ($this->package_type !== PackageType::PACKAGE) {
            $this->insurance = 0;
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
