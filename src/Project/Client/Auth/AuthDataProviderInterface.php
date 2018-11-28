<?php

namespace Project\Client\Auth;


interface AuthDataProviderInterface
{
    const AUTHORIZATION_HEADER_KEY = "Authorization";

    public function getAsHeader(): array;
}