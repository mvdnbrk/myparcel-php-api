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
    public $isDelivered;

    /**
     * @var array
     */
    public $history;

    /**
     * Create a new Track Trace instance.
     *
     * @param  array  $attributes
     */
    public function __construct(array $attributes = [])
    {
        $this->history = [];

        parent::__construct($attributes);

        $this->isDelivered = collect($this->status)->get('final', false);
    }

    /**
     * Determines if this shipment has reached a final state.
     *
     * @return bool
     */
    public function getFinalAttribute()
    {
        return $this->isDelivered;
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
     * Set the history.
     *
     * @param  array  $array
     * @return void
     */
    public function setHistoryAttribute($array = [])
    {
        $this->history = collect($array)->map(function ($item) {
                return collect($item)->all();
            })
            ->all();
    }
}
