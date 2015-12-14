<?php

/**
 * (c) Spryker Systems GmbH copyright protected
 */

namespace SprykerEngine\Shared\Kernel;

use SprykerEngine\Shared\Kernel\ClassResolver\ClassNotFoundException;
use SprykerEngine\Shared\Kernel\ClassResolver\InstanceBuilder;

class ClassMapFactory
{

    const CLASS_MAP_FILE_NAME = '.class_map';

    /**
     * @var self
     */
    protected static $instance;

    /**
     * @var array
     */
    protected $map;

    /**
     * @var InstanceBuilder
     */
    private $instanceBuilder;

    /**
     * @return self
     */
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    private function __construct()
    {
        $this->map = include_once APPLICATION_ROOT_DIR . DIRECTORY_SEPARATOR . self::CLASS_MAP_FILE_NAME;
        $this->instanceBuilder = new InstanceBuilder();
    }

    /**
     * @param string $application
     * @param string $bundle
     * @param string $suffix
     * @param string $layer
     * @param array $arguments
     *
     * @throws ClassNotFoundException
     *
     * @return object
     */
    public function create($application, $bundle, $suffix, $layer = null, $arguments = [])
    {
        $key = $this->createKey($application, $bundle . Store::getInstance()->getStoreName(), $suffix, $layer);

        if (!array_key_exists($key, $this->map)) {
            $key = $this->createKey($application, $bundle, $suffix, $layer);
            if (!array_key_exists($key, $this->map)) {
                throw new ClassNotFoundException(sprintf(
                    'Couldn\'t find class "%s\\%s\\%s\\%s" when trying to create with class map factory.',
                    $application,
                    $bundle,
                    $layer,
                    $suffix
                ));
            }
        }
        $className = $this->map[$key];

        return $this->instanceBuilder->createInstance($className, $arguments);
    }

    /**
     * @param string $application
     * @param string $bundle
     * @param string $suffix
     * @param string $layer
     *
     * @return bool
     */
    public function has($application, $bundle, $suffix, $layer = null)
    {
        $key = $this->createKey($application, $bundle, $suffix, $layer);

        return array_key_exists($key, $this->map);
    }

    /**
     * @param string $application
     * @param string $bundle
     * @param string $suffix
     * @param string $layer
     *
     * @return string
     */
    protected function createKey($application, $bundle, $suffix, $layer = null)
    {
        if ($layer !== null) {
            $key = implode('|', [$application, $bundle, $layer, $suffix]);
        } else {
            $key = implode('|', [$application, $bundle, $suffix]);
        }

        return $key;
    }

}
