<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Shared\Kernel\Transfer;

use ArrayObject;
use Exception;
use InvalidArgumentException;
use Serializable;
use Spryker\Service\UtilEncoding\Model\Json;
use Spryker\Shared\Kernel\Transfer\Exception\RequiredTransferPropertyException;
use Spryker\Shared\Kernel\Transfer\Exception\TransferUnserializationException;
use Zend\Filter\Word\UnderscoreToCamelCase;

abstract class AbstractTransfer implements TransferInterface, Serializable
{

    /**
     * @var array
     */
    private $modifiedProperties = [];

    /**
     * @var array
     */
    protected $transferMetadata = [];

    /**
     * @var \Zend\Filter\Word\UnderscoreToCamelCase
     */
    private static $filterUnderscoreToCamelCase;

    public function __construct()
    {
        $this->initCollectionProperties();
    }

    /**
     * @param bool $isRecursive
     *
     * @return array
     */
    public function toArray($isRecursive = true)
    {
        return $this->propertiesToArray($this->getPropertyNames(), $isRecursive, 'toArray');
    }

    /**
     * @param bool $isRecursive
     *
     * @return array
     */
    public function modifiedToArray($isRecursive = true)
    {
        return $this->propertiesToArray($this->modifiedProperties, $isRecursive, 'modifiedToArray');
    }

    /**
     * @param string $propertyName
     *
     * @return bool
     */
    public function isModified($propertyName)
    {
        return in_array($propertyName, $this->modifiedProperties);
    }

    /**
     * @return void
     */
    protected function initCollectionProperties()
    {
        foreach ($this->transferMetadata as $property => $metaData) {
            if ($metaData['is_collection'] && $this->$property === null) {
                $this->$property = new ArrayObject();
            }
        }
    }

    /**
     * @param array $properties
     * @param bool $isRecursive
     * @param string $childConvertMethodName
     *
     * @return array
     */
    private function propertiesToArray(array $properties, $isRecursive, $childConvertMethodName)
    {
        $values = [];

        foreach ($properties as $property) {
            $value = $this->callGetMethod($property);

            $arrayKey = $this->transformUnderscoreArrayKey($property);

            if (is_object($value)) {
                if ($isRecursive && $value instanceof TransferInterface) {
                    $values[$arrayKey] = $value->$childConvertMethodName($isRecursive);
                } elseif ($isRecursive && $this->isCollection($property) && count($value) >= 1) {
                    $values = $this->addValuesToCollection($value, $values, $arrayKey, $isRecursive, $childConvertMethodName);
                } else {
                    $values[$arrayKey] = $value;
                }
                continue;
            }

            $values[$arrayKey] = $value;
        }

        return $values;
    }

    /**
     * @return array
     */
    private function getPropertyNames()
    {
        return array_keys($this->transferMetadata);
    }

    /**
     * @param array $data
     * @param bool $ignoreMissingProperty
     *
     * @return $this
     */
    public function fromArray(array $data, $ignoreMissingProperty = false)
    {
        $allProperties = $this->getPropertyNames();
        foreach ($data as $property => $value) {
            $property = $this->filterPropertyUnderscoreToCamelCase($property);

            if ($this->hasProperty($property, $allProperties, $ignoreMissingProperty) === false) {
                continue;
            }

            if ($this->isCollection($property)) {
                $value = $this->processCollection($value, $property, $ignoreMissingProperty);
            } elseif ($this->isTransferClass($property)) {
                $value = $this->initializeNestedTransferObject($property, $value, $ignoreMissingProperty);
            }

            $this->callSetMethod($property, $value);
        }

        return $this;
    }

    /**
     * @param string $elementType
     * @param array|\ArrayObject $arrayObject
     * @param bool $ignoreMissingProperty
     *
     * @return \ArrayObject
     */
    protected function processArrayObject($elementType, $arrayObject, $ignoreMissingProperty = false)
    {
        $transferObjectsArray = new ArrayObject();
        foreach ($arrayObject as $arrayElement) {
            if (!is_array($arrayElement)) {
                $transferObjectsArray->append(new $elementType());
                continue;
            }

            if ($this->isAssociativeArray($arrayElement)) {
                $transferObject = $this->createInstance($elementType);
                $transferObject->fromArray($arrayElement, $ignoreMissingProperty);
                $transferObjectsArray->append($transferObject);
            } else {
                foreach ($arrayElement as $arrayElementItem) {
                    $transferObject = $this->createInstance($elementType);
                    $transferObject->fromArray($arrayElementItem, $ignoreMissingProperty);
                    $transferObjectsArray->append($transferObject);
                }
            }
        }

        return $transferObjectsArray;
    }

    /**
     * @param array $array
     *
     * @return bool
     */
    private function isAssociativeArray(array $array)
    {
        return array_values($array) !== $array;
    }

    /**
     * @param string $property
     *
     * @return bool
     */
    private function isCollection($property)
    {
        return $this->transferMetadata[$property]['is_collection'];
    }

    /**
     * @param string $property
     *
     * @return bool
     */
    private function isTransferClass($property)
    {
        return $this->transferMetadata[$property]['is_transfer'];
    }

    /**
     * @param string $property
     *
     * @return void
     */
    protected function addModifiedProperty($property)
    {
        if (!in_array($property, $this->modifiedProperties)) {
            $this->modifiedProperties[] = $property;
        }
    }

    /**
     * @param string $property
     *
     * @throws \Spryker\Shared\Kernel\Transfer\Exception\RequiredTransferPropertyException
     *
     * @return void
     */
    protected function assertPropertyIsSet($property)
    {
        if ($this->$property === null) {
            throw new RequiredTransferPropertyException(sprintf(
                'Missing required property "%s" for transfer %s.',
                $property,
                get_class($this)
            ));
        }
    }

    /**
     * @param string $property
     *
     * @throws \Spryker\Shared\Kernel\Transfer\Exception\RequiredTransferPropertyException
     *
     * @return void
     */
    protected function assertCollectionPropertyIsSet($property)
    {
        /** @var \ArrayObject $collection */
        $collection = $this->$property;
        if ($collection->count() === 0) {
            throw new RequiredTransferPropertyException(sprintf(
                'Empty required collection property "%s" for transfer %s.',
                $property,
                get_class($this)
            ));
        }
    }

    /**
     * @param string $property
     *
     * @return string
     */
    protected function getTypeForProperty($property)
    {
        return $this->transferMetadata[$property]['type'];
    }

    /**
     * Performance-Speedup. We do not want another instance of the filter for each property.
     *
     * @return \Zend\Filter\Word\UnderscoreToCamelCase
     */
    private function getFilterUnderscoreToCamelCase()
    {
        if (self::$filterUnderscoreToCamelCase === null) {
            self::$filterUnderscoreToCamelCase = new UnderscoreToCamelCase();
        }

        return self::$filterUnderscoreToCamelCase;
    }

    /**
     * @param string $property
     * @param mixed $value
     *
     * @throws \InvalidArgumentException
     *
     * @return void
     */
    private function callSetMethod($property, $value)
    {
        $setter = 'set' . ucfirst($property);

        try {
            $this->$setter($value);
        } catch (Exception $exception) {
            throw new InvalidArgumentException(
                sprintf('Could not call "%s(%s)" (type %s) in "%s". Maybe there is a type miss match.', $setter, $value, gettype($value), get_class($this)),
                $exception->getCode(),
                $exception
            );
        }
    }

    /**
     * @param string $property
     * @param mixed $value
     * @param bool $ignoreMissingProperty
     *
     * @return \Spryker\Shared\Kernel\Transfer\TransferInterface
     */
    private function initializeNestedTransferObject($property, $value, $ignoreMissingProperty = false)
    {
        $type = $this->getTypeForProperty($property);
        $transferObject = $this->createInstance($type);

        if (is_array($value)) {
            $transferObject->fromArray($value, $ignoreMissingProperty);
            $value = $transferObject;
        }

        return $value;
    }

    /**
     * @param mixed $value
     * @param string $property
     * @param bool $ignoreMissingProperty
     *
     * @return \ArrayObject
     */
    private function processCollection($value, $property, $ignoreMissingProperty = false)
    {
        $elementType = $this->transferMetadata[$property]['type'];
        $value = $this->processArrayObject($elementType, $value, $ignoreMissingProperty);

        return $value;
    }

    /**
     * @param string $type
     *
     * @return \Spryker\Shared\Kernel\Transfer\TransferInterface
     */
    private function createInstance($type)
    {
        return new $type();
    }

    /**
     * @param string $property
     * @param array $properties
     * @param bool $ignoreMissingProperty
     *
     * @throws \InvalidArgumentException
     *
     * @return bool
     */
    private function hasProperty($property, array $properties, $ignoreMissingProperty)
    {
        if (in_array($property, $properties)) {
            return true;
        }

        if ($ignoreMissingProperty) {
            return false;
        }

        throw new InvalidArgumentException(
            sprintf('Missing property "%s" in "%s"', $property, get_class($this))
        );
    }

    /**
     * @param string $key
     *
     * @return string
     */
    private function filterPropertyUnderscoreToCamelCase($key)
    {
        $filter = $this->getFilterUnderscoreToCamelCase();
        $property = lcfirst($filter->filter($key));

        return $property;
    }

    /**
     * @param string $property
     *
     * @return mixed
     */
    private function callGetMethod($property)
    {
        $getter = 'get' . ucfirst($property);
        $value = $this->$getter();

        return $value;
    }

    /**
     * @param string $property
     *
     * @return mixed
     */
    private function transformUnderscoreArrayKey($property)
    {
        $property = $this->transferMetadata[$property]['name_underscore'];

        return $property;
    }

    /**
     * @param mixed $value
     * @param array $values
     * @param string $arrayKey
     * @param bool $isRecursive
     * @param string $childConvertMethodName
     *
     * @return array
     */
    private function addValuesToCollection($value, $values, $arrayKey, $isRecursive, $childConvertMethodName)
    {
        foreach ($value as $elementKey => $arrayElement) {
            if (is_array($arrayElement) || is_scalar($arrayElement)) {
                $values[$arrayKey][$elementKey] = $arrayElement;
            } else {
                $values[$arrayKey][$elementKey] = $arrayElement->$childConvertMethodName($isRecursive);
            }
        }

        return $values;
    }

    /**
     * @return string
     */
    public function serialize()
    {
        $jsonUtil = new Json();

        return $jsonUtil->encode($this->modifiedToArray());
    }

    /**
     * @param string $serialized
     *
     * @throws \Spryker\Shared\Kernel\Transfer\Exception\TransferUnserializationException
     *
     * @return void
     */
    public function unserialize($serialized)
    {
        try {
            $jsonUtil = new Json();
            $this->fromArray($jsonUtil->decode($serialized, true), true);
            $this->initCollectionProperties();
        } catch (Exception $exception) {
            throw new TransferUnserializationException(
                sprintf(
                    'Failed to unserialize %s. Updating or clearing your data source may solve this problem: %s',
                    get_class($this),
                    $exception->getMessage()
                ),
                $exception->getCode(),
                $exception
            );
        }
    }

    /**
     * @return void
     */
    public function __wakeup()
    {
        $this->initCollectionProperties();
    }

}
