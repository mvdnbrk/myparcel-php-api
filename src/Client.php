<?php

namespace HeyHoo\MyParcel;

class Client
{
    /**
     * Version of our client.
     */
    const CLIENT_VERSION = "1.0.0";

    /**
     * Create a new MyParcel_API_Client Instance
     */
    public function __construct()
    {
    }

    /**
     * Send the parcel
     *
     * @return boolen
     */
    public function send()
    {
        return true;
    }
}
