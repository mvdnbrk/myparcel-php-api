<?php

namespace Mvdnbrk\MyParcel\Endpoints;

use Mvdnbrk\MyParcel\Exceptions\InvalidHousenumberException;
use Mvdnbrk\MyParcel\Exceptions\InvalidPostalCodeException;
use Mvdnbrk\MyParcel\Resources\ServicePoint as ServicePointResource;
use Mvdnbrk\MyParcel\Resources\Time;
use Mvdnbrk\MyParcel\Support\Str;
use Tightenco\Collect\Support\Collection;

class ServicePoints extends BaseEndpoint
{
    const CARRIER = 1;

    /** @var string */
    public $postal_code;

    /** @var string */
    public $housenumber;

    /** @var array */
    public $validPostalCodes = [
        'BE' => '/^[1-9]{1}\d{3}$/',
        'NL' => '/^[1-9]{1}\d{3}[A-Z]{2}$/',
    ];

    /** @var string */
    protected $country;

    /** @var string */
    protected $carrier = self::CARRIER;

    /** @var \Mvdnbrk\MyParcel\Resources\Time */
    protected $cutoffTime;

    protected function boot(): void
    {
        $this->cutoffTime = new Time('15:30');
    }

    public function get(array $filters = []): Collection
    {
        $response = $this->performApiCall(
            'GET',
            'delivery_options'.$this->buildQueryString($this->getFilters($filters))
        );

        $collection = new Collection();

        collect($response->data->pickup)->each(function ($item) use ($collection) {
            $collection->push(new ServicePointResource($item));
        });

        return $collection;
    }

    public function getCountry(): string
    {
        return $this->country;
    }

    protected function getFilters(array $filters): array
    {
        return array_merge([
            'cc' => $this->getCountry(),
            'carrier' => $this->carrier,
            'number' => $this->housenumber,
            'postal_code' => $this->postal_code,
            'cutoff_time' => $this->cutoffTime->get(),
        ], $filters);
    }

    protected function setCountry(): void
    {
        $postalCodes = collect($this->validPostalCodes);

        $postalCodes->each(function ($value, $key) {
            if (preg_match($value, $this->postal_code)) {
                $this->country = $key;
            }
        });
    }

    public function setCutoffTime(string $value): self
    {
        $this->cutoffTime = new Time($value);

        return $this;
    }

    /**
     * @param  string|int  $value
     * @throws \Mvdnbrk\MyParcel\Exceptions\InvalidHousenumberException
     */
    public function setHousenumber($value): self
    {
        $this->housenumber = filter_var($value, FILTER_SANITIZE_NUMBER_INT);

        if (! is_numeric($this->housenumber)) {
            throw new InvalidHousenumberException;
        }

        return $this;
    }

    /**
     * @throws \Mvdnbrk\MyParcel\Exceptions\InvalidPostalCodeException
     */
    public function setPostalCode(string $value): self
    {
        $this->postal_code = preg_replace('/\s+/', '', Str::upper($value));
        $this->setCountry();

        if ($this->country === null) {
            throw new InvalidPostalCodeException;
        }

        return $this;
    }
}
