<?php

namespace Mvdnbrk\MyParcel\Contracts;

interface Jsonable
{
    public function toJson(int $options = 0): string;
}
