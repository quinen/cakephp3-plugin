<?php

namespace Quinen\View\Helper;

trait IconTrait
{

    public function fa($name, array $options = [])
    {
        $options += [
            'iconSet'       => "fa",
            'isFixedWidth'  => true,
            'size'          => 1,
        ];

        $classes = [];

        // size, included in the custom css
        if (in_array($options['size'], ['lg',2,3,4,5])) {
            $size = "fa-".str_pad($options['size'], 2, "x");
            $classes[] = $size;
        }
        unset($options['size']);

        // fixed width
        if ($options['isFixedWidth']) {
            $classes[] = "fa-fw";
        }
        unset($options['isFixedWidth']);

        $options = $this->injectClasses($classes, $options);

        return $this->gi($name, $options);
    }

    public function gi($name, array $options = [])
    {
        $options += [
            'size'      => 1,
            'spaceAfter'=> true
        ];

        // size, included in the custom css
        if ($options['size']>1) {
            $size = "gi-".$options['size']."x";
            $options = $this->injectClasses($size, $options);
        }
        unset($options['size']);

        // generate a space after the icon automatically
        $spaceAfter = "";
        if ($options['spaceAfter']) {
            $spaceAfter = " ";
        }
        unset($options['spaceAfter']);

        return parent::icon($name, $options).$spaceAfter;
    }

}
