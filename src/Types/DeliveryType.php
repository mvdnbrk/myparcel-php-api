<?php

namespace Mvdnbrk\MyParcel\Types;

class DeliveryType
{
    /**
     * This options is only available for certain addresses in the Netherlands.
     * It allows a recipient to have their package delivered
     * early in the morning except on Saturday and Sunday.
     */
    const MORNING = 1;

    /**
     * This is the standard delivery type (default).
     */
    const STANDARD = 2;

    /**
     * The package is delivered in the evening.
     */
    const EVENING = 3;

    /**
     * The package is delivered to a pick up point.
     */
    const PICKUP = 4;

    /**
     * The same as pickup but the package is available for pickup before 8:30AM.
     */
    const PICKUP_EXPRESS = 5;
}
