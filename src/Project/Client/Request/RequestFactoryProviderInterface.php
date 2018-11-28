<?php

namespace Project\Client\Request;


interface RequestFactoryProviderInterface
{
    public function get(): RequestFactory;
}