<?php


namespace CustomerApi\ServiceFactory\Service;


use CustomerApi\Service\TokenService;
use Psr\Container\ContainerInterface;

class TokenServiceFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new TokenService();
    }
}
