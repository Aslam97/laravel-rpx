<?php

namespace Aslam\Rpx\Traits;

trait PublicCustomer
{
    /**
     * getProvince
     *
     * @return \Aslam\Response\Response
     */
    public function getProvince()
    {
        return $this->send('POST', 'getProvince');
    }

    /**
     * getCity
     *
     * @param  string $province
     * @return \Aslam\Response\Response
     */
    public function getCity(string $province = '')
    {
        return $this->send('POST', 'getCity', compact('province'));
    }

    /**
     * getService
     *
     * @return \Aslam\Response\Response
     */
    public function getService()
    {
        return $this->send('POST', 'getService');
    }

    /**
     * getOrigin
     *
     * @return \Aslam\Response\Response
     */
    public function getOrigin()
    {
        return $this->send('POST', 'getOrigin');
    }

    /**
     * getDestination
     *
     * @return \Aslam\Response\Response
     */
    public function getDestination()
    {
        return $this->send('POST', 'getDestination');
    }

    /**
     * getRates
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
     * getRatesPostalCode
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
        $data = compact('origin_postal_code', 'destination_postal_code', 'service_type', 'weight', 'disc');
        return $this->send('POST', 'getRatesPostalCode', $data);
    }

    public function getTrackingAWB()
    {

    }

    public function getClearanceAWB()
    {

    }
}
