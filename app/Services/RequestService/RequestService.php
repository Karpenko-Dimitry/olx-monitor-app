<?php

namespace App\Services\RequestService;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

/**
 * Class ApiRequest
 * @package App\Services\ApiRequest
 */
class RequestService
{
    /**
     * Error code - invalid request
     */
    public const ERROR_CODE_INVALID_REQUEST = 400;

    /**
     *
     */
    public const JSON_TYPE = 'json';

    /**
     *
     */
    public const FORM_TYPE = 'form';

    /**
     *
     */
    public const MULTIPART_TYPE = 'multipart';

    /**
     *
     */
    public const DATA_TYPE = 'data';

    /**
     * @var string|null
     */
    private ?string $url;

    /**
     * @var integer|null
     */
    private ?int $errorCode = 0;

    /**
     * @var string|null
     */
    private ?string $errorMessage = null;

    /**
     * @var array
     */
    private array $headers = [];

    /**
     * @var array
     */
    private array $auth = [];

    /**
     * @var array
     */
    private array $postData = [];

    /**
     * @var string|null
     */
    private ?string $file = null;

    /**
     * @var string
     */
    private string $method = 'GET';

    /**
     * @var string
     */
    private string $type = self::JSON_TYPE;

    /**
     * @var array
     */
    private array $additionalData = [];

    /**
     * @var string|null
     */
    private ?string $link = null;

    /**
     * @var array
     */
    private array $requiredParameters = [];

    /**
     * @param array $parameters
     * @return $this
     */
    public function setAdditionalParameters($parameters = []): RequestService
    {
        $this->additionalData = $parameters;
        return $this;
    }

    /**
     * @param $link
     * @return $this
     */
    public function setLink($link): RequestService
    {
        $this->link = $link;
        return $this;
    }

    /**
     * @param $path
     * @return $this
     */
    public function setFile($path): RequestService
    {
        $this->file = $path;
        return $this;
    }

    /**
     * @param $type
     * @return $this
     */
    public function setType($type): self
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @param $array
     * @return $this
     */
    public function setHeaders($array): RequestService
    {
        $this->headers = array_merge($this->headers, $array);
        return $this;
    }

    /**
     * @param array $parameters
     * @return $this
     */
    public function setRequiredParameters(array $parameters = []): RequestService
    {
        $this->requiredParameters = $parameters;
        return $this;
    }

    /**
     * @return false|mixed|\Psr\Http\Message\ResponseInterface
     */
    public function execute(): mixed
    {
        $this->setUrl($this->link);

        $this->setRemoteParameters($this->additionalData);

        try {
            return $this->executeRemoteRequest();
        } catch (GuzzleException $e) {
            $this->setResponseErrorCode($e->getCode());
            $this->setResponseErrorMessage($e->getMessage());
            return false;
        }
    }


    /**
     * @param $code
     */
    public function setResponseErrorCode($code): void
    {
        $this->errorCode = $code;
    }

    /**
     * @return null|int
     */
    public function getErrorCode(): ?int
    {
        return $this->errorCode;
    }

    /**
     * @param $message
     */
    public function setResponseErrorMessage($message): void
    {
        $this->errorMessage = $message;
    }

    /**
     * @return string|null
     */
    public function getErrorMessage(): ?string
    {
        return $this->errorMessage;
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * @param $url
     */
    private function setUrl($url): void
    {
        $this->url = $url;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return null|string
     */
    public function getFile(): ?string
    {
        return $this->file;
    }

    /**
     * @return array
     */
    public function getParameters(): array
    {
        return $this->postData;
    }

    /**
     * @return array
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }

    /**
     * @return array
     */
    public function getAuth(): array
    {
        return $this->auth;
    }

    /**
     * @param string $username
     * @param string $password
     * @return self
     */
    public function setAuth(string $username, string $password): self
    {
        $this->auth = [
            $username, $password
        ];

        return $this;
    }

    /**
     * @param array $parameters
     */
    private function setRemoteParameters($parameters = []): void
    {
        foreach ($parameters as $parameter => $value) {
            $this->postData[$parameter] = $value;
        }
    }

    /**
     * @return mixed|\Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    private function executeRemoteRequest(): \Psr\Http\Message\ResponseInterface
    {
        $client = new Client();

        $data = [];
        if (count($this->getParameters())) {
            if (strtoupper($this->getMethod()) === 'GET') {
                $this->setUrl(addQueryToUrl($this->getUrl(), $this->getParameters()));
            } else {
                if ($this->getType() === self::JSON_TYPE) {
                    $data = ['json' => $this->getParameters()];
                } elseif ($this->getType() === self::FORM_TYPE) {
                    $data = ['form_params' => $this->getParameters()];
                } else {
                    $data = ['body' => $this->getParameters()];
                }
            }
        } elseif ($this->getFile()) {
            $data = ['body' => fopen($this->getFile(), 'r')];
        }

        if (count($this->getHeaders())) {
            $data = array_merge($data, ['headers' => $this->getHeaders()]);
        }

        if (count($this->getAuth())) {
            $data = array_merge($data, ['auth' => $this->getAuth()]);
        }

        return $client->request($this->getMethod(), $this->getUrl(), $data);
    }

    /**
     * @param string $method
     * @return $this
     */
    public function setMethod($method = 'GET'): RequestService
    {
        $this->method = $method;

        return $this;
    }


    /**
     * @param $request
     * @param array $required
     * @return bool
     */
    private function validateResponse($request, $required = []): bool
    {
        if (!is_array($required) || !count($required)) {
            return true;
        }

        foreach ($required as $field) {
            if (!isset($request->$field)) {
                return false;
            }
        }

        return true;
    }

    /**
     * @return $this
     */
    public function resetParameters(): RequestService
    {
        $parameters = [
            'url',
            'link',
            'file',
            'errorCode',
            'errorMessage'
        ];

        foreach ($parameters as $parameter) {
            $this->$parameter = null;
        }

        $arrayParameters = [
            'postData',
            'additionalData',
            'requiredParameters',
            'headers'
        ];

        foreach ($arrayParameters as $parameter) {
            $this->$parameter = [];
        }

        return $this;
    }
}
