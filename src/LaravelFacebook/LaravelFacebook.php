<?php

namespace AndyJessop\LaravelFacebook;

use Illuminate\Config\Repository as Config;
use Illuminate\Routing\UrlGenerator as Url;
use Facebook\Facebook;

class LaravelFacebook extends Facebook
{
    /**
     * @var Config
     */
    protected $config_handler;

    /**
     * @var Url
     */
    protected $url;

    /**
     * @param Config  $config_handler
     * @param Url  $url
     * @param array   $config
     */
    public function __construct(Config $config_handler, Url $url, array $config)
    {
        $this->config_handler = $config_handler;
        $this->url = $url;

        parent::__construct($config);
    }

    /**
     * Generate an OAuth 2.0 authorization URL for authentication.
     *
     * @param array $scope
     * @param string $callback_url
     *
     * @return string
     */
    public function getLoginUrl(array $scope = [], $callback_url = '')
    {
        $scope = $this->getScope($scope);
        $callback_url = $this->getCallbackUrl($callback_url);

        return $this->getRedirectLoginHelper()->getLoginUrl($callback_url, $scope);
    }

    /**
     * Generate a re-request authorization URL.
     *
     * @param array $scope
     * @param string $callback_url
     *
     * @return string
     */
    public function getReRequestUrl(array $scope, $callback_url = '')
    {
        $scope = $this->getScope($scope);
        $callback_url = $this->getCallbackUrl($callback_url);

        return $this->getRedirectLoginHelper()->getReRequestUrl($callback_url, $scope);
    }

    /**
     * Generate a re-authentication authorization URL.
     *
     * @param array $scope
     * @param string $callback_url
     *
     * @return string
     */
    public function getReAuthenticationUrl(array $scope = [], $callback_url = '')
    {
        $scope = $this->getScope($scope);
        $callback_url = $this->getCallbackUrl($callback_url);

        return $this->getRedirectLoginHelper()->getReAuthenticationUrl($callback_url, $scope);
    }

    /**
     * Get an access token from a redirect.
     *
     * @param string $callback_url
     * @return \Facebook\Authentication\AccessToken|null
     */
    public function getAccessTokenFromRedirect($callback_url = '')
    {
        $callback_url = $this->getCallbackUrl($callback_url);

        return $this->getRedirectLoginHelper()->getAccessToken($callback_url);
    }

    /**
     * Get the fallback scope if none provided.
     *
     * @param array $scope
     *
     * @return array
     */
    private function getScope(array $scope)
    {
        return $scope ?: $this->config_handler->get('laravel-facebook.default_scope');
    }

    /**
     * Get the fallback callback redirect URL if none provided.
     *
     * @param string $callback_url
     *
     * @return string
     */
    private function getCallbackUrl($callback_url)
    {
        $callback_url = $callback_url ?: $this->config_handler->get('laravel-facebook.default_redirect_uri');

        return $this->url->to($callback_url);
    }
}
