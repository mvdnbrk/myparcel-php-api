<?php

namespace Mvdnbrk\MyParcel\Resources;

class ShipmentOptions extends BaseResource
{
    /**
     * The delivery type.
     *
     * @var int
     */
    public $delivery_type;

    /**
     * The description that will appear on the shipment label.
     *
     * @var string
     */
    public $label_description;

    /**
     * Large format package.
     *
     * @var bool
     */
    public $large_format;

    /**
     * Deliver the package to the recipient only.
     *
     * @var bool
     */
    public $only_recipient;

    /**
     * The package type. For international shipments only package type 1 (package) is allowed.
     *
     * @var int
     */
    public $package_type;

    /**
     * Return the package if the recipient is not home.
     *
     * @var bool
     */
    public $return;

    /**
     * Reciepient must sign for the package.
     *
     * @var bool
     */
    public $signature;

    /**
     * Create a new Shipment Options resource.
     *
     * @param  array  $attributes
     * @return void
     */
    public function __construct(array $attributes = [])
    {
        $this->setDefaultOptions();

        parent::__construct($attributes);
    }

    /**
     * Set default options for a shipment.
     *
     * @return $this
     */
    public function setDefaultOptions()
    {
        $this->return = false;
        $this->signature = false;
        $this->large_format = false;
        $this->package_type = 1;
        $this->delivery_type = 2;
        $this->only_recipient = false;

        return $this;
    }

    /**
     * Get the description for the shipment. Alias for label_description.
     *
     * @return string
     */
    public function getDescriptionAttribute()
    {
        return $this->label_description;
    }

    /**
     * Sets the description. Alias for label_description.
     *
     * @param  string  $value
     * @return void
     */
    public function setDescriptionAttribute($value)
    {
        $this->label_description = $value;
    }

    /**
     * Convert the ShipmentOptions resource to an array.
     *
     * @return array
     */
    public function toArray()
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
