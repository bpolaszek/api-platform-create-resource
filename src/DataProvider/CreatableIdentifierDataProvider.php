<?php

namespace BenTools\ApiPlatform\CreateResource\DataProvider;

use ApiPlatform\Core\DataProvider\ChainItemDataProvider;
use ApiPlatform\Core\DataProvider\ItemDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use BenTools\ApiPlatform\CreateResource\Factory\ItemFactoryInterface;

final class CreatableIdentifierDataProvider implements ItemDataProviderInterface, RestrictedDataProviderInterface
{
    private const HAS_IDENTIFIER_CONVERTER = 'has_identifier_converter';

    /**
     * @var ItemDataProviderInterface[]
     */
    private $dataProviders;

    /**
     * @var ItemFactoryInterface
     */
    private $defaultFactory;

    private $classes = [];

    public function __construct(iterable $dataProviders, ItemFactoryInterface $defaultFactory)
    {
        $this->dataProviders = $dataProviders;
        $this->defaultFactory = $defaultFactory;
    }

    public function registerClass(string $resourceClass, ?ItemFactoryInterface $factory = null): void
    {
        $this->classes[$resourceClass] = $factory;
    }

    public function getItem(string $resourceClass, $id, string $operationName = null, array $context = [])
    {
        $context[self::HAS_IDENTIFIER_CONVERTER] = false;
        if ($this->dataProviders instanceof \Traversable) {
            $dataProviders = [];
            foreach ($this->dataProviders as $dataProvider) {
                if ($dataProvider instanceof self) {
                    continue;
                }
                $dataProviders[] = $dataProvider;
            }
            $this->dataProviders = $dataProviders;
        }
        $dataProvider = new ChainItemDataProvider($this->dataProviders);
        $item = $dataProvider->getItem($resourceClass, $id, $operationName, $context);

        return $item ?? $this->createItem($resourceClass, $id, $context);
    }

    private function createItem(string $resourceClass, $id, array $context = [])
    {
        $factory = $this->classes[$resourceClass] ?? $this->defaultFactory;

        return $factory->createItem($resourceClass, $id, $context);
    }

    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        return 'PUT' === $operationName && \array_key_exists($resourceClass, $this->classes);
    }
}
