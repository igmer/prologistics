<?php
// src/Application/CoreBundle/Form/Extension/FileTypeExtension.php
namespace Application\CoreBundle\Form\Extension;

use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class FileTypeExtension extends AbstractTypeExtension
{
    /**
     * Returns the name of the type being extended.
     *
     * @return string The name of the type being extended
     */
    public function getExtendedType()
    {
        return 'file';
    }

    /**
     * Add the options
     *
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setOptional(array('display_name', 'thumbnail', 'img_width', 'img_height', 'file_type', 'directory', 'horizontal_align'));
    }

    /**
     *
     * @param FormView $view
     * @param FormInterface $form
     * @param array $options
     */
    public function buildView(FormView $view, FormInterface $form, array $options) {
        $configureOptions = array('display_name', 'thumbnail', 'img_width', 'img_height', 'file_type', 'directory', 'horizontal_align');

        foreach ($configureOptions as $option) {
            if(array_key_exists($option, $options)) {
                $view->vars[$option] = $options[$option];
            }
        }
    }
}
