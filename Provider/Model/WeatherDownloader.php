<?php

declare(strict_types=1);

namespace Weather\Provider\Model;

use GuzzleHttp\ClientFactory;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\ResponseFactory;
use Magento\Framework\App\Response\Http;
use Magento\Framework\Webapi\Rest\Request;
use Psr\Log\LoggerInterface;
use Weather\Provider\Provider\ConfigProvider;
use Weather\Provider\Cron\FetchWeather;

/**
 * Class GitApiService
 */
class WeatherDownloader
{
    private ResponseFactory $responseFactory;

    private ClientFactory $clientFactory;

    private ConfigProvider $configProvider;

    private LoggerInterface $logger;

    /**
     * GitApiService constructor
     *
     * @param ClientFactory $clientFactory
     * @param ResponseFactory $responseFactory
     * @param ConfigProvider $configProvider
     * @param LoggerInterface $logger
     */
    public function __construct(
        ClientFactory   $clientFactory,
        ResponseFactory $responseFactory,
        ConfigProvider  $configProvider,
        LoggerInterface $logger
    ) {
        $this->clientFactory = $clientFactory;
        $this->responseFactory = $responseFactory;
        $this->configProvider = $configProvider;
        $this->logger = $logger;
    }

    /**
     * Fetch some data from API
     */
    public function execute(): array
    {
        if (!$this->configProvider->isEnabled()) {
            return [];
        }
        $endpoint = $this->prepareEndpoint();
        $response = $this->doRequest($endpoint);
        $status = $response->getStatusCode(); // 200 status code
//        var_dump(get_class_methods($response));die();
        if ($status !== Http::STATUS_CODE_200) {
            $this->logger->warning($response->getReasonPhrase());
        }
        $responseBody = $response->getBody();
        $responseContent = $responseBody->getContents();
        if ($responseContent) {
            return json_decode($responseContent, true) ?? [];
        }
        return [];
    }

    /**
     * Do API request with provided params
     *
     * @param string $uriEndpoint
     * @param array $params
     * @param string $requestMethod
     *
     * @return Response
     */
    private function doRequest(
        string $uriEndpoint,
        array  $params = [],
        string $requestMethod = Request::HTTP_METHOD_GET
    ): Response
    {
        $client = $this->clientFactory->create(['config' => [
            'base_uri' => $uriEndpoint
        ]]);

        try {
            $response = $client->request(
                $requestMethod,
                $uriEndpoint,
                ['query' => $params]
            );
        } catch (GuzzleException $exception) {
            $response = $this->responseFactory->create([
                'status' => $exception->getCode(),
                'reason' => $exception->getMessage()
            ]);
        }

        return $response;
    }

    /**
     * @return string
     */
    private function prepareEndpoint(): string
    {
        $user = $this->configProvider->getUser(); //'dfg_';
        $password = $this->configProvider->getPassword(); //'tIj7v55KUp';
        $validateTime = 'now';
        $location = $this->configProvider->getCity(); //'50.9492852,28.6416207';
        $parameters = implode(',',array_keys(FetchWeather::$weatherParams['current']));
        $api_endpoind  = $this->configProvider->getApiEndpoint();
        $endpoint = 'https://'.$user.':'. $password . $api_endpoind .'/'. $validateTime .'/'. $parameters .'/'. $location .'/json?model=mix';
        return $endpoint;
    }
}
