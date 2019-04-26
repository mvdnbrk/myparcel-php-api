<?php

namespace Mvdnbrk\MyParcel\Endpoints;

use Mvdnbrk\MyParcel\Resources\Shipment;
use Mvdnbrk\MyParcel\Resources\TrackTrace as TrackTraceResource;

class TrackTrace extends BaseEndpoint
{
    /**
     * Get detailed track and trace information for a shipment.
     *
     * @param  \Mvdnbrk\MyParcel\Resources\Shipment|int  $value
     * @return \Mvdnbrk\MyParcel\Resources\TrackTrace
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

        return new TrackTraceResource(
            collect(
                collect($response->data->tracktraces)->first()
            )->all()
        );
    }
}
