<?php

namespace Mvdnbrk\MyParcel\Resources;

class Webhook extends BaseResource
{
    /** @var int */
    public $id;

    /** @var int */
    public $account_id;

    /** @var int */
    public $shop_id;

    /** @var string */
    public $hook;

    /** @var string */
    public $url;
}
