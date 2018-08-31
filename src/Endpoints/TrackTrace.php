<?php

namespace Mvdnbrk\MyParcel\Endpoints;

use Mvdnbrk\MyParcel\Resources\Shipment;
use Mvdnbrk\MyParcel\Resources\TrackTrace as TrackTraceResource;

class TrackTrace extends BaseEndpoint
{
    /**
     * Get detailed track and trace information for a shipment.
     * Returns null if there is no tracking information available.
     *
     * @param  int|\Mvdnbrk\MyParcel\Resources\Shipment $value
     * @return null|\Mvdnbrk\MyParcel\Resources\TrackTrace
     */
    public function get($value)
    {
        if ($value instanceof Shipment) {
            $value = $value->id;
        }

        $response = $this->performApiCall(
            'GET',
            'tracktraces/'.$value
        );

        $trace = collect(collect($response->data->tracktraces)->first());

        if ($trace->isEmpty()) {
            return null;
        }

        return new TrackTraceResource($trace->all());
    }
}
