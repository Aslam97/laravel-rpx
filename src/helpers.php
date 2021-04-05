<?php

/**
 * RPX Helpers
 *
 * @author     Aslam H
 * @license    MIT
 * @copyright  (c) 2021, Aslam H
 */

if (!function_exists('rpx')) {

    /**
     * rpx
     *
     * @return \Aslam\Rpx\Rpx
     */
    function rpx()
    {
        return app(\Aslam\Rpx\Rpx::class);
    }
}

if (!function_exists('build_rpx_xml')) {

    /**
     * build_rpx_xml
     *
     * @param  string $methodName
     * @param  array $rpxElement
     * @return \DOMDocument
     */
    function build_rpx_xml(string $methodName, array $rpxElement)
    {
        $dom = new DOMDocument();
        $dom->preserveWhiteSpace = false;
        $dom->formatOutput = true;

        // ROOT
        $root = $dom->createElementNS('http://schemas.xmlsoap.org/soap/envelope/', 'soapenv:Envelope');

        $namespaces = [
            'xmlns:xsi' => 'http://www.w3.org/2001/XMLSchema-instance',
            'xmlns:xsd' => 'http://www.w3.org/2001/XMLSchema',
            'xmlns:urn' => 'urn:rpxwsdl',
        ];

        foreach ($namespaces as $key => $value) {
            $root->setAttribute($key, $value);
        }

        $dom->appendChild($root);

        // HEADER
        $header = $dom->createElement('soapenv:Header');
        $root->appendChild($header);

        // BODY
        $body = $dom->createElement('soapenv:Body');
        $root->appendChild($body);

        // METHOD
        $method = $dom->createElement("urn:{$methodName}");
        $method->setAttribute('soapenv:encodingStyle', 'http://schemas.xmlsoap.org/soap/encoding/');
        $body->appendChild($method);

        // CONTENT
        $attributes = [
            'xsi:type' => 'xsd:string',
            'xs:type' => 'type:string',
            'xmlns:xs' => 'http://www.w3.org/2000/XMLSchema-instance',
        ];

        foreach ($rpxElement as $key => $value) {
            $field = $dom->createElement($key, $value);

            foreach ($attributes as $key => $value) {
                $field->setAttribute($key, $value);
            }

            $method->appendChild($field);
        }

        return $dom->saveXML($dom->documentElement);
    }
}
