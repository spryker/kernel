<?php

namespace Unit\SprykerEngine\Zed\Kernel\IdeAutoCompletion;

use SprykerFeature\Shared\Library\Autoloader;
use SprykerEngine\Zed\Kernel\IdeAutoCompletion\MethodTagBuilder\ConstructableMethodTagBuilder;

/**
 * @group Kernel
 * @group MethodTagBuilder
 */
class ConstructableMethodTagBuilderTest extends \PHPUnit_Framework_TestCase
{

    public function testBuildMethodTagsShouldReturnVendorMethodTagIfProjectDoesNotOverrideIt()
    {
        Autoloader::allowNamespace('VendorNamespace');
        $options = [
            ConstructableMethodTagBuilder::OPTION_KEY_APPLICATION => 'Application',
            ConstructableMethodTagBuilder::OPTION_KEY_PATH_PATTERN => 'Communication/',
            ConstructableMethodTagBuilder::OPTION_KEY_PROJECT_PATH_PATTERN => __DIR__ . '/Fixtures/src/',
            ConstructableMethodTagBuilder::OPTION_KEY_VENDOR_PATH_PATTERN => __DIR__ . '/Fixtures/vendor/*/*/src/'
        ];

        require_once(__DIR__ . '/Fixtures/vendor/vendor/package/src/VendorNamespace/Application/Bundle/Communication/Plugin/Foo.php');
        require_once(__DIR__ . '/Fixtures/vendor/vendor/package/src/VendorNamespace/Application/Bundle/Communication/Plugin/Bar.php');

        $methodTagBuilder = new ConstructableMethodTagBuilder($options);
        $methodTags = $methodTagBuilder->buildMethodTags('Bundle');

        $expectedMethodTag =
            ' * @method \VendorNamespace\Application\Bundle\Communication\Plugin\Foo createPluginFoo()'
        ;
        $this->assertContains($expectedMethodTag, $methodTags);

        $expectedMethodTag =
            ' * @method \VendorNamespace\Application\Bundle\Communication\Plugin\Bar createPluginBar()'
        ;

        $this->assertContains($expectedMethodTag, $methodTags);
    }

    public function testBuildMethodTagsShouldReturnProjectMethodTagIfProjectOverrideIt()
    {
        Autoloader::allowNamespace('ProjectNamespace');
        $options = [
            ConstructableMethodTagBuilder::OPTION_KEY_APPLICATION => 'Application',
            ConstructableMethodTagBuilder::OPTION_KEY_PATH_PATTERN => 'Communication/',
            ConstructableMethodTagBuilder::OPTION_KEY_PROJECT_PATH_PATTERN => __DIR__ . '/Fixtures/src/',
            ConstructableMethodTagBuilder::OPTION_KEY_VENDOR_PATH_PATTERN => __DIR__ . '/Fixtures/vendor/*/*/src/'
        ];

        require_once(__DIR__ . '/Fixtures/vendor/vendor/package/src/VendorNamespace/Application/Bundle/Communication/Plugin/Baz.php');
        require_once(__DIR__ . '/Fixtures/src/ProjectNamespace/Application/Bundle/Communication/Plugin/Baz.php');

        $methodTagBuilder = new ConstructableMethodTagBuilder($options);
        $methodTags = $methodTagBuilder->buildMethodTags('Bundle');

        $expectedMethodTag =
            ' * @method \ProjectNamespace\Application\Bundle\Communication\Plugin\Baz createPluginBaz()'
        ;
        $this->assertContains($expectedMethodTag, $methodTags);
    }

    public function testBuildMethodTagsShouldReturnMethodNameWithParamsIfClassConstructorHasParams()
    {
        Autoloader::allowNamespace('ProjectNamespace');
        $options = [
            ConstructableMethodTagBuilder::OPTION_KEY_APPLICATION => 'Application',
            ConstructableMethodTagBuilder::OPTION_KEY_PATH_PATTERN => 'Persistence/',
            ConstructableMethodTagBuilder::OPTION_KEY_PROJECT_PATH_PATTERN => __DIR__ . '/Fixtures/src/',
            ConstructableMethodTagBuilder::OPTION_KEY_VENDOR_PATH_PATTERN => __DIR__ . '/Fixtures/vendor/*/*/src/'
        ];

        require_once(__DIR__ . '/Fixtures/src/ProjectNamespace/Application/Bundle/Persistence/BundleQueryContainer.php');

        $methodTagBuilder = new ConstructableMethodTagBuilder($options);
        $methodTags = $methodTagBuilder->buildMethodTags('Bundle');
        $expectedMethodTag =
            ' * @method \ProjectNamespace\Application\Bundle\Persistence\BundleQueryContainer createBundleQueryContainer(array $foo, $bar = true, $baz = null, $baz2 = \'abc\', $baz3 = \'\\\\\')'
        ;
        $this->assertContains($expectedMethodTag, $methodTags);
    }
}
