<?php namespace AdditionalMetafields\Widgets;

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
use AdditionalMetafields\MetafieldsHelper;

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
            $arrMetaFields = $this->metaFields;
            foreach ($arrMetaFieldsPlus as $field => $label)
            {
                $arrMetaFields[] = $field;

                // TODO Translation
                $GLOBALS['TL_LANG']['MSC']['aw_' . $field] = $label;
            }
            $this->metaFields = $arrMetaFields;
        }
        return parent::generate();
    }
}
