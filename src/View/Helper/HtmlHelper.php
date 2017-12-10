<?php
namespace Quinen\View\Helper;

use BootstrapUI\View\Helper\HtmlHelper as UseHelper;
use Cake\Utility\Hash;
use Quinen\View\Helper\Traits\Bootstrap3Trait;
use Quinen\View\Helper\Traits\HtmlTrait;
use Quinen\View\Helper\Traits\IconTrait;
use Quinen\View\Helper\Traits\TableTrait;

class HtmlHelper extends UseHelper
{
    use Bootstrap3Trait;
    use HtmlTrait;
    use IconTrait;
    use TableTrait;

    /*
    public function icon($name, array $options = [])
    {
        return $this->fa($name, $options);
    }
    */
}
