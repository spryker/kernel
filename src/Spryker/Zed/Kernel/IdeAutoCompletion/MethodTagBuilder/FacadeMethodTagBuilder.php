<?php

/**
 * (c) Spryker Systems GmbH copyright protected
 */

namespace Spryker\Zed\Kernel\IdeAutoCompletion\MethodTagBuilder;

use Symfony\Component\OptionsResolver\OptionsResolver;

class FacadeMethodTagBuilder extends AbstractSingleFileMethodTagBuilder
{

    const METHOD_STRING_PATTERN = '@method {{className}} facade()';
    const PATH_PATTERN = 'Business/';
    const FILE_NAME_SUFFIX = 'Facade.php';

    /**
     * @param \Symfony\Component\OptionsResolver\OptionsResolver $resolver
     *
     * @return void
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setDefaults([
            self::OPTION_KEY_METHOD_STRING_PATTERN => self::METHOD_STRING_PATTERN,
            self::OPTION_KEY_PATH_PATTERN => self::PATH_PATTERN,
            self::OPTION_KEY_FILE_NAME_SUFFIX => self::FILE_NAME_SUFFIX,
        ]);
    }

    /**
     * @param string $bundle
     * @param array $methodTags
     *
     * @return array
     */
    public function buildMethodTags($bundle, array $methodTags = [])
    {
        $methodTag = $this->getMethodTag($bundle);
        if ($methodTag) {
            $methodTags[] = $methodTag;
        }

        return $methodTags;
    }

}
