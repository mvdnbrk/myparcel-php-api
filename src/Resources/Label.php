<?php

namespace Mvdnbrk\MyParcel\Resources;

use Mvdnbrk\MyParcel\Types\LabelPositions;
use Mvdnbrk\MyParcel\Types\PaperSize;

class Label extends BaseResource
{
    /** @var string */
    protected $format;

    /** @var int */
    protected $positions;

    public function __construct(array $attributes = [])
    {
        $this->format = PaperSize::A6;

        parent::__construct($attributes);
    }

    public function setFormatAttribute(string $value): void
    {
        if ($value === PaperSize::A4 && ! $this->positions) {
            $this->positions = LabelPositions::TOP_LEFT;
        }

        if ($value === PaperSize::A6) {
            $this->positions = null;
        }

        $this->format = $value;
    }

    public function setPositionAttribute(int $value): void
    {
        $this->positions = $value;
    }

    public function setSizeAttribute(string $value): void
    {
        $this->setFormatAttribute($value);
    }
}
