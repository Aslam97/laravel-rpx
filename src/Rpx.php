<?php

namespace Aslam\Rpx;

use Aslam\Response\ConnectionException;
use Aslam\Response\RequestException;
use Aslam\Response\Response;
use Aslam\Rpx\Traits;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\HandlerStack;

class Rpx
{
    use Traits\PublicCustomer;
    use Traits\Customer;

    /**
     * apiUrl
     *
     * @var string
     */
    private $apiUrl;

    /**
     * accountNumber
     *
     * @var string
     */
    protected $account_number;

    /**
     * username
     *
     * @var string
     */
    protected $username;

    /**
     * password
     *
     * @var string
     */
    protected $password;

    /**
     * Format
     *
     * @var string
     */
    protected $format;

    /**
     * Namespace
     *
     * @var string
     */
    private $namespace;

    /**
     * __construct
     *
     * @return void
     */
    public function __construct()
    {
        $this->apiUrl = config('rpx.api_url');
        $this->account_number = config('rpx.account_number');
        $this->username = config('rpx.username');
        $this->password = config('rpx.password');
        $this->format = config('rpx.format');
    }

    /**
     * Send the request to the given URL.
     *
     * @param  string $httpMethod
     * @param  string $uniformResourceName
     * @param  array $data
     * @return \Aslam\Response\Response
     *
     * @throws \Aslam\Response\RequestException
     */
    public function send(string $httpMethod, string $uniformResourceName, array $data = [])
    {
        try {
            return tap(
                new Response(
                    $this->withNamespace($uniformResourceName . 'Response')
                        ->buildClient($uniformResourceName, $data)
                        ->request($httpMethod, $this->apiUrl)
                ),
                function ($response) {
                    if (!$response->successful()) {
                        $response->throw();
                    }
                }
            );

        } catch (ConnectException $e) {
            throw new ConnectionException($e->getMessage(), 0, $e);
        } catch (RequestException $e) {
            return $e->response;
        }
    }

    /**
     * Build the Guzzle client.
     *
     * @return \GuzzleHttp\Client
     */
    public function buildClient(string $uniformResourceName, array $data)
    {
        $xml = build_rpx_xml(
            $uniformResourceName,
            array_merge($cd = array_merge($this->credentials(), $data), $this->responseFormat())
        );

        return new Client([
            'handler' => $this->buildHandlerStack(),
            'http_errors' => false,
            'headers' => [
                'Accept' => 'text/xml; charset=ISO-8859-1',
                'Content-Type' => 'text/xml',
            ],
            'body' => $xml,
        ]);
    }

    /**
     * Build the before sending handler stack.
     *
     * @return \GuzzleHttp\HandlerStack
     */
    public function buildHandlerStack()
    {
        return tap(HandlerStack::create(), function ($stack) {
            $stack->push($this->buildResponseHandler());
        });
    }

    /**
     * Build the response handler.
     *
     * @return \Closure
     */
    public function buildResponseHandler()
    {
        return function ($handler) {
            return function ($request, $options) use ($handler) {
                $promise = $handler($request, $options);

                return $promise->then(function ($response) {

                    $doc = new \DOMDocument('1.0', 'ISO-8859-1');
                    $doc->loadXML((string) $response->getBody());

                    $xpath = new \DOMXPath($doc);
                    $xpath->registerNamespace('ns1', 'urn:rpxwsdl');

                    $item = $xpath->query("/SOAP-ENV:Envelope/SOAP-ENV:Body/ns1:{$this->namespace}/return");
                    $decode = json_decode($item->item(0)->textContent, true);

                    $result = is_null($decode)
                    ? json_encode(['RPX' => ['DATA' => 'No Data Found']])
                    : $item->item(0)->textContent;

                    $streamBody = fopen('data://text/plain,' . $result, 'r');
                    return $response->withBody(new \GuzzleHttp\Psr7\Stream($streamBody));
                }
                );
            };
        };
    }

    /**
     * Set namespace
     *
     * @param  string  $namespace
     * @return $this
     */
    public function withNamespace($namespace)
    {
        return tap($this, function ($request) use ($namespace) {
            $this->namespace = $namespace;
        });
    }

    /**
     * credentials
     *
     * @return array
     */
    public function credentials()
    {
        return [
            'user' => $this->username,
            'password' => $this->password,
        ];
    }

    /**
     * responseFormat
     *
     * @return array
     */
    public function responseFormat()
    {
        return [
            'format' => $this->format,
        ];
    }

    /**
     * List all deprecated method for public customers
     *
     * @return array
     */
    public function publicDeprecatedMethods()
    {
        return [
            'getRPXOffice',
            'getClearanceAWB',
            'getRouteOrigin',
            'getRouteDestination',
        ];
    }
}
