<?php

namespace Aslam\Rpx\Modules;

use Aslam\Rpx\Rpx;

class NonCustomer extends Rpx
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
