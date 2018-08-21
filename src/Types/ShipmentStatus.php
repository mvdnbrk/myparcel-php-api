<?php

namespace Mvdnbrk\MyParcel\Types;

class ShipmentStatus
{
    const CONCEPT = 1;

    const REGISTERED = 2;

    const HANDED_TO_CARRIER = 3;

    const SORTING = 4;

    const DISTRIBUTION = 5;

    const CUSTOMS = 6;

    const AT_RECIPIENT = 7;

    const READY_FOR_PICKUP = 8;

    const PACKAGE_PICKED_UP = 9;

    const RETURN_SHIPMENT_READY_FOR_PICKUP = 10;

    const RETURN_SHIPMENT_PACKAGE_PICKED_UP = 11;

    const LETTER = 12;

    const UNKNOWN = 99;
}
