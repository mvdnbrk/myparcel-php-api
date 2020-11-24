<?php

namespace Mvdnbrk\MyParcel\Endpoints;

use Mvdnbrk\MyParcel\Resources\Label;
use Mvdnbrk\MyParcel\Resources\Shipment;
use Mvdnbrk\MyParcel\Types\PaperSize;

class ShipmentLabels extends BaseEndpoint
{
    const SEPARATOR = ";";

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
        $value = $this->prepLabelRequest($value);

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

    private function prepLabelRequest($value): string
    {
        if (is_array($value)) {
            $shipmentIds = [];
            foreach ($value as $val) {
                $shipmentIds[] = $this->prepLabelRequest($val);
            }
            return implode(static::SEPARATOR, $shipmentIds);
        }

        if ($value instanceof Shipment) {
            return $value->id;
        } else {
            return $value;
        }
    }
}
