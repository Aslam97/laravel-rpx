<?php

namespace Aslam\Rpx\Traits;

trait PublicCustomer
{
    /**
     *  Get Provinces of RPX Office located.
     *
     * @return \Aslam\Response\Response
     */
    public function getProvince()
    {
        return $this->send('POST', 'getProvince');
    }

    /**
     * Get List of City for Destination Shipping
     *
     * @param  string $province
     * @return \Aslam\Response\Response
     */
    public function getCity(string $province = '')
    {
        return $this->send('POST', 'getCity', compact('province'));
    }

    /**
     * Get Service Type for Shipping
     *
     * @return \Aslam\Response\Response
     */
    public function getService()
    {
        return $this->send('POST', 'getService');
    }

    /**
     * Get Origin City for Shipping
     *
     * @return \Aslam\Response\Response
     */
    public function getOrigin()
    {
        return $this->send('POST', 'getOrigin');
    }

    /**
     * Get Destination City for Shipping
     *
     * @return \Aslam\Response\Response
     */
    public function getDestination()
    {
        return $this->send('POST', 'getDestination');
    }

    /**
     * Get RPX Domestic Rates from Origin to Destination with a Specific Weight and Discount
     *
     * @param  string $origin
     * @param  string $destination
     * @param  string $service_type
     * @param  float|null $weight
     * @param  float|null $disc
     * @return \Aslam\Response\Response
     */
    public function getRates(
        string $origin,
        string $destination,
        string $service_type = '',
        float $weight = null,
        float $disc = null
    ) {
        $data = compact('origin', 'destination', 'service_type', 'weight', 'disc');
        return $this->send('POST', 'getRates', $data);
    }

    /**
     * Get RPX Domestic Rates from Origin Postal Code to Destination Postal Code with a Specific Weight and Discount
     *
     * @param  string $origin_postal_code
     * @param  string $destination_postal_code
     * @param  string $service_type
     * @param  float|null $weight
     * @param  float|null $disc
     * @return \Aslam\Response\Response
     */
    public function getRatesPostalCode(
        string $origin_postal_code,
        string $destination_postal_code,
        string $service_type = '',
        float $weight = null,
        float $disc = null
    ) {
        $format = $this->format;
        $account_number = $this->account_number;
        $data = compact(
            'origin_postal_code',
            'destination_postal_code',
            'service_type',
            'weight',
            'disc',
            'format',
            'account_number'
        );

        return $this->send('POST', 'getRatesPostalCode', $data);
    }

    /**
     * Get Tracking Data from an AWB
     *
     * @param  string $awb
     * @return \Aslam\Response\Response
     */
    public function getTrackingAWB(string $awb)
    {
        return $this->send('POST', 'getTrackingAWB', compact('awb'));
    }

    /**
     * Get List of Postal Code (“city_id” input is Optional, Taken from Service “getCity”)
     *
     * @param  string|null $city_id
     * @param  string|null $cod_area
     * @param  string|null $service_type
     * @return \Aslam\Response\Response
     */
    public function getPostalCode(string $city_id = null, string $cod_area = null, string $service_type = null)
    {
        $format = $this->format;
        $data = compact(
            'city_id',
            'format',
            'cod_area',
            'service_type'
        );

        return $this->send('POST', 'getPostalCode', $data);
    }

    /**
     * Get List of AWB by Reference Number
     *
     * @param  mixed $reference_no
     * @return \Aslam\Response\Response
     */
    public function getAWBbyReference(string $reference_no)
    {
        return $this->send('POST', 'getAWBbyReference', compact('reference_no'));
    }
}
