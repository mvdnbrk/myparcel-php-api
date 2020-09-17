<?php

namespace Mvdnbrk\MyParcel\Endpoints;

use Mvdnbrk\MyParcel\Resources\Label;
use Mvdnbrk\MyParcel\Resources\Shipment;
use Mvdnbrk\MyParcel\Types\PaperSize;

class ShipmentLabels extends BaseEndpoint
{
    /** @var \Mvdnbrk\MyParcel\Resources\Label */
    protected $label;

    public function boot(): void
    {
        $this->label = new Label;
    }

    /**
     * Get a shipment label by shipment object or id.
     *
     * @param  \Mvdnbrk\MyParcel\Resources\Shipment|int  $value
     * @return string
     */
    public function get($value): string
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

    public function setFormatA4(): self
    {
        $this->label->setFormatAttribute(PaperSize::A4);

        return $this;
    }

    public function setLabel(Label $label): self
    {
        $this->label = $label;

        return $this;
    }
}
