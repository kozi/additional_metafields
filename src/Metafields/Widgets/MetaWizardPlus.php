<?php namespace Metafields\Widgets;

    /**
     * Contao Open Source CMS
     * Copyright (C) 2005-2015 Leo Feyer
     *
     *
     * PHP version 5
     * @copyright  Martin Kozianka 2013-2015 <http://kozianka.de/>
     * @author     Martin Kozianka <http://kozianka.de/>
     * @package    contao-metafields
     * @license    LGPL
     * @filesource
     */

/**
 * Class MetaWizardPlus
 *
 * Extends the MetaWizard class
 * @copyright  Martin Kozianka 2013-2015 <http://kozianka.de/>
 * @author     Martin Kozianka <http://kozianka.de/>
 * @package    contao-metafields
 */

use Contao\MetaWizard;
use Metafields\MetafieldsHelper;

class MetaWizardPlus extends MetaWizard
{
    /**
     * Generate the widget and return it as string
     * @return string
     */
    public function generate()
    {
        $helper            = MetafieldsHelper::getInstance();
        $arrMetaFieldsPlus = $helper->getFields($this->activeRecord);

        if ($arrMetaFieldsPlus !== null)
        {
            $cssStyle  = '';
            $tmplStyle = ".tl_metawizard label[for^=ctrl_%s] { font-weight:bold; }\n";
            $arrMetaFields = $this->metaFields;
            foreach ($arrMetaFieldsPlus as $field => $label)
            {
                $arrMetaFields[] = $field;

                // TODO Translation
                $GLOBALS['TL_LANG']['MSC']['aw_'.$field] = $label;

                // Add CSS style
                $cssStyle .= sprintf($tmplStyle, $field);
            }
            $this->metaFields         = $arrMetaFields;
            $GLOBALS['TL_MOOTOOLS'][] = "\n\n<style>\n".$cssStyle."</style>\n\n";
        }
        return parent::generate();
    }
}
