<?php

namespace Aslam\Rpx\Traits;

trait Customer
{
    /**
     * Get Revenue from an Account for a Periodic Time
     *
     * @param  string $trackdate_from
     * @param  string $trackdate_to
     * @return \Aslam\Response\Response
     */
    public function getRevenue(string $trackdate_from, string $trackdate_to)
    {
        $account_number = $this->account_number;
        $data = compact('account_number', 'trackdate_from', 'trackdate_to');

        return $this->asXML()->send('POST', 'getRevenue', $data);
    }

    /**
     * Get RPX Domestic Rates for a Customer Account Number
     * from Origin to Destination with a Specific Weight and Discount with/without Service Type
     *
     * @param  string $service_type
     * @param  string $origin
     * @param  string $destination
     * @param  float|null $weight
     * @param  float|null $disc
     * @return \Aslam\Response\Response
     */
    public function getCustumerRates(
        ?string $service_type,
        string $origin,
        string $destination,
        ?float $weight,
        ?float $disc
    ) {
        $account_number = $this->account_number;
        $data = compact(
            'account_number',
            'service_type',
            'origin',
            'destination',
            'weight',
            'disc'
        );

        return $this->send('POST', 'getCustomerRates', $data);
    }

    /**
     * Send shipment data
     *
     * @param  array $fields
     * @return \Aslam\Response\Response
     */
    public function sendShipmentData(array $fields)
    {
        return $this->send('POST', 'sendShipmentData', $fields);
    }

    /**
     * Send pickup request
     *
     * @param  array $fields
     * @return \Aslam\Response\Response
     */
    public function sendPickupRequest(array $fields)
    {
        return $this->send('POST', 'sendPickupRequest', $fields);
    }

    /**
     * Void the shipment data
     *
     * @param  array $fields
     * @return \Aslam\Response\Response
     */
    public function voidShipmentData(array $fields)
    {
        return $this->send('POST', 'voidShipmentData', $fields);
    }
}
