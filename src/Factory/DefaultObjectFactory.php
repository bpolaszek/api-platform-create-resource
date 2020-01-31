<?php

namespace BenTools\ApiPlatform\CreateResource\Factory;

use ApiPlatform\Core\Api\IdentifiersExtractorInterface;
use Symfony\Component\PropertyAccess\PropertyAccessorInterface;

final class DefaultObjectFactory implements ItemFactoryInterface
{
    /**
     * @var PropertyAccessorInterface
     */
    private $propertyAccessor;

    /**
     * @var IdentifiersExtractorInterface
     */
    private $identifiersExtractor;

    public function __construct(PropertyAccessorInterface $propertyAccessor, IdentifiersExtractorInterface $identifiersExtractor)
    {
        $this->propertyAccessor = $propertyAccessor;
        $this->identifiersExtractor = $identifiersExtractor;
    }

    /**
     * @param string $resourceClass
     * @param $id
     * @param array $context
     * @return mixed
     */
    public function createItem(string $resourceClass, $id, array $context = [])
    {
        $item = new $resourceClass();
        $identifiers = $this->identifiersExtractor->getIdentifiersFromResourceClass($resourceClass);
        if (1 !== \count($identifiers)) {
            throw new \RuntimeException(\sprintf('Invalid number of identifiers for class %s', $resourceClass));
        }
        $this->propertyAccessor->setValue($item, reset($identifiers), $id);
        return $item;
    }
}
