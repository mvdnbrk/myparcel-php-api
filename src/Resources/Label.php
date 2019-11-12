<?php

namespace Mvdnbrk\MyParcel\Resources;

use Mvdnbrk\MyParcel\Types\LabelPositions;
use Mvdnbrk\MyParcel\Types\PaperSize;

class Label extends BaseResource
{
    /**
     * @var string
     */
    protected $format;

    /**
     * @var int
     */
    protected $positions;

    /**
     * Create a new label instance.
     *
     * @param  array  $attributes
     */
    public function __construct(array $attributes = [])
    {
        $this->format = PaperSize::A6;

        parent::__construct($attributes);
    }

    /**
     * Sets paper format for the label.
     *
     * @param  string  $value
     * @return void
     */
    public function setFormatAttribute($value)
    {
        if ($value === PaperSize::A4 && ! $this->positions) {
            $this->positions = LabelPositions::TOP_LEFT;
        }

        if ($value === PaperSize::A6) {
            $this->positions = null;
        }

        $this->format = $value;
    }

    /**
     * Sets a position for the label. Alias for positions.
     *
     * @param  int  $value
     * @return void
     */
    public function setPositionAttribute($value)
    {
        $this->positions = $value;
    }

    /**
     * Sets a size fot the label. Alias for format.
     *
     * @param  string  $value
     * @return void
     */
    public function setSizeAttribute($value)
    {
        $this->setFormatAttribute($value);
    }
}
