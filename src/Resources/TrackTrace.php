<?php

namespace Mvdnbrk\MyParcel\Resources;

class TrackTrace extends Trace
{
    /**
     * @var int
     */
    public $shipment_id;

    /**
     * @var bool
     */
    public $final;

    /**
     * @var array
     */
    public $history;

    /**
     * Create a new Track Trace Collection instance.
     *
     * @param  array  $attributes
     */
    public function __construct(array $attributes = [])
    {
        $this->history = [];

        parent::__construct($attributes);
    }

    /**
     * Get a collection with TrackTrace items for this
     * shipment including the latest trace.
     *
     * @return \Tightenco\Collect\Support\Collection
     */
    public function getItemsAttribute()
    {
        return collect($this->history)
            ->prepend([
                'code' => $this->code,
                'description' => $this->description,
                'time' => $this->time,
            ])
            ->map(function ($item) {
                return new Trace($item);
            });
    }

    /**
     * Sets the hostory.
     *
     * @param array  $array
     */
    public function setHistoryAttribute($array = [])
    {
        $this->history = collect($array)->map(function ($item) {
            return collect($item)->all();
        })
        ->all();
    }
}
