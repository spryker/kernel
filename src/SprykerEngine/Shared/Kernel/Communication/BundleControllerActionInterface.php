<?php


namespace SprykerEngine\Shared\Kernel\Communication;

interface BundleControllerActionInterface
{

    /**
     * @return string
     */
    public function getBundle();

    /**
     * @return string
     */
    public function getController();

    /**
     * @return string
     */
    public function getAction();
}
