<?php

namespace Mvdnbrk\MyParcel\Types;

class HookType
{
    /**
     * Whenever the status of a shipment changes this webhook will send you an update with the new value.
     * Update is not send when status is 1 or 2.
     */
    const SHIPMENT_STATUS_CHANGED = 'shipment_status_change';

    /**
     * Whenever a label is created this webhook will send you a message with the url of the label.
     */
    const SHIPMENT_LABEL_CREATED = 'shipment_label_created';
}
