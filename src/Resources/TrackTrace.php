<?php

namespace Mvdnbrk\MyParcel\Resources;

use Illuminate\Support\Collection;

class TrackTrace extends Trace
{
    /** @var int */
    public $shipment_id;

    /** @var bool */
    public $isDelivered;

    /** @var array */
    public $history;

    public function __construct(array $attributes = [])
    {
        $this->history = [];

        parent::__construct($attributes);

        $this->isDelivered = collect($this->status)->get('final', false);
    }

    public function getFinalAttribute(): bool
    {
        return $this->isDelivered;
    }

    public function getItemsAttribute(): Collection
    {
        return (new Collection($this->history))
            ->prepend([
                'code' => $this->code,
                'description' => $this->description,
                'time' => $this->time,
            ])
            ->map(function ($item) {
                return new Trace($item);
            });
    }

    public function setHistoryAttribute($array = []): void
    {
        $this->history = collect($array)->map(function ($item) {
            return collect($item)->all();
        })->all();
    }
}
