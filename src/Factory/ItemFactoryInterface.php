<?php

namespace BenTools\ApiPlatform\CreateResource\Factory;

interface ItemFactoryInterface
{
    /**
     * @param string $resourceClass
     * @param $id
     * @param array $context
     * @return mixed
     */
    public function createItem(string $resourceClass, $id, array $context = []);
}
