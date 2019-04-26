<?php


namespace CustomerApi\ServiceFactory\Service;


use CustomerApi\Service\AccessTokenService;
use Psr\Container\ContainerInterface;

class AccessTokenServiceFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new AccessTokenService();
    }
}
