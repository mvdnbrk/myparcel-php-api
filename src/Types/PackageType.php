<?php

namespace Mvdnbrk\MyParcel\Types;

class PackageType
{
    /**
     * This is the standard package type.
     * Most commonly used for shipments.
     */
    const PACKAGE = 1;

    /**
     * This package type is only available for shipments in
     * the Netherlands that fit in a standard mailbox.
     * It does not support any additional options.
     */
    const MAILBOX_PACKAGE = 2;

    /**
     * The label for this shipment is unpaid meaning that you will need to
     * pay the postal office/courier to sent this letter/package.
     * Therefore, it does not support any additional options.
     */
    const LETTER = 3;
}
