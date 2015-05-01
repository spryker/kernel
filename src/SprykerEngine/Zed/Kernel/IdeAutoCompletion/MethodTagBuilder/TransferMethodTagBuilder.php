<?php

namespace SprykerEngine\Zed\Kernel\IdeAutoCompletion\MethodTagBuilder;

use Symfony\Component\OptionsResolver\OptionsResolver;

class TransferMethodTagBuilder extends AbstractMultiFileMethodTagBuilder
{

    const METHOD_STRING_PATTERN = '@method \{{className}} transfer{{methodName}}()';
    const PATH_PATTERN = 'Transfer/';

    /**
     * @param OptionsResolver $resolver
     */
    protected function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setDefaults([
            self::OPTION_KEY_PATH_PATTERN => self::PATH_PATTERN,
            self::OPTION_KEY_METHOD_STRING_PATTERN => self::METHOD_STRING_PATTERN,
        ]);
    }

    /**
     * @param $bundle
     * @param array $methodTags
     *
     * @return array
     */
    public function buildMethodTags($bundle, array $methodTags = [])
    {
        $generatedMethodTags = $this->getMethodTags($bundle);
        if ($generatedMethodTags) {
            $methodTags = $methodTags + $generatedMethodTags;
        }

        return $methodTags;
    }


}
