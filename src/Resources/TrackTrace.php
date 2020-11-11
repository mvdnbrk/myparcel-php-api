<?php

namespace Mvdnbrk\MyParcel\Resources;

use Illuminate\Support\Collection;

class TrackTrace extends Trace
{
    /** @var int */
    public $shipment_id;

    /** @var bool */
    public $isDelivered;

    /** @var string */
    public $link;

    /** @var string */
    public $link_portal;

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

    public function getLinkConsumerPortalAttribute(): string
    {
        return $this->link_portal;
    }

    public function setLinkConsumerPortalAttribute(?string $value): void
    {
        $this->link_portal = $value ?? '';
    }

    public function getLinkTracktraceAttribute(): string
    {
        return $this->link;
    }

    public function setLinkTracktraceAttribute(?string $value): void
    {
        $this->link = $value ?? '';
    }

    public function setHistoryAttribute(array $array = []): void
    {
        $this->history = collect($array)->map(function ($item) {
            return collect($item)->all();
        })->all();
    }
}
