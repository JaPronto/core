<?php

namespace Tests\Traits;


trait HasApiResource
{
    /**
     *  Get the api resource for the test
     */
    abstract function apiResource(): string;

    /**
     * @param $routeName
     * @return \Illuminate\Foundation\Testing\TestResponse
     */
    public function makePostRequest($routeName)
    {
        return $this->makeRequest('POST', $this->getRoute($routeName), ...array_slice(func_get_args(), 1));
    }

    /**
     * @param $routeName
     * @return \Illuminate\Foundation\Testing\TestResponse
     */
    public function makeGetRequest($routeName)
    {
        return $this->makeRequest('GET', $this->getRoute($routeName), ...array_slice(func_get_args(), 1));
    }

    /**
     * @return \Illuminate\Foundation\Testing\TestResponse
     */
    public function makePutRequest($routeName)
    {
        return $this->makeRequest('PUT', $this->getRoute($routeName), ...array_slice(func_get_args(), 1));
    }

    /**
     * @param $routeName
     * @return \Illuminate\Foundation\Testing\TestResponse
     */
    public function makePatchRequest($routeName)
    {
        return $this->makeRequest('PATCH', $this->getRoute($routeName), ...array_slice(func_get_args(), 1));
    }

    /**
     * @param $routeName
     * @return \Illuminate\Foundation\Testing\TestResponse
     */
    public function makeDeleteRequest($routeName)
    {
        return $this->makeRequest('DELETE', $this->getRoute($routeName), ...array_slice(func_get_args(), 1));
    }

    /**
     * @param string $method
     * @param $uri
     * @param array $data
     * @param array $headers
     * @return \Illuminate\Foundation\Testing\TestResponse
     */
    public function makeRequest($method = 'POST', $uri, $data = [], $headers = [])
    {
        return $this->json($method, $uri, $data ?: [], $headers ?: []);
    }

    /**
     * Creates a route based on resource name
     * @param $routeName
     * @return string
     */
    public function getRoute($routeName)
    {
        $api = $this->apiResource();

        if (is_array($routeName)) {
            return route("$api.{$routeName[0]}", array_slice($routeName, 1));
        }

        return route("$api.$routeName");
    }

}