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
        return $this->withNamespace('getProvinceResponse')->send('POST', 'getProvince');
    }

    /**
     * getCity
     *
     * @param  string $province
     * @return \Aslam\Response\Response
     */
    public function getCity(string $province = '')
    {
        return $this->withNamespace('getCityResponse')->send('POST', 'getCity', compact('province'));
    }
}
