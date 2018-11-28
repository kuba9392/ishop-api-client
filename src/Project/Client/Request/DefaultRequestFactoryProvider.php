<?php

namespace Project\Client\Request;


class DefaultRequestFactoryProvider implements RequestFactoryProviderInterface
{
    const CLIENT_BASE_URI = "http://grzegorz.demos.i-sklep.pl/rest_api/shop_api/v1/";

    public function get(): RequestFactory
    {
        return new RequestFactory(self::CLIENT_BASE_URI);
    }
}