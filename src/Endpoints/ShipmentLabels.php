<?php

namespace Mvdnbrk\MyParcel\Endpoints;

use Mvdnbrk\MyParcel\Resources\Label;
use Mvdnbrk\MyParcel\Resources\Shipment;

class ShipmentLabels extends BaseEndpoint
{
    /**
     * @var \Mvdnbrk\MyParcel\Resources\Label
     */
    protected $label;

    /**
     * Boot the ShipmentLabels endpoint.
     *
     * @return void
     */
    public function boot()
    {
        $this->label = new Label;
    }

    /**
     * Get a shipment label by shipment object or id.
     *
     * @param \Mvdnbrk\MyParcel\Resources\Shipment|int $value
     * @return string
     */
    public function get($value)
    {
        if ($value instanceof Shipment) {
            $value = $value->id;
        }

        $response = $this->performApiCall(
            'GET',
            'shipment_labels/'.$value.$this->buildQueryString(
                $this->label->toArray()
            ),
            null,
            ['Accept' => 'application/pdf']
        );

        return $response;
    }

    /**
     * Set a label.
     *
     * @param  \Mvdnbrk\MyParcel\Resources\Label  $label
     * @return $this
     */
    public function setLabel(Label $label)
    {
        $this->label = $label;

        return $this;
    }
}
