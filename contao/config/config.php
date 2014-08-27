<?php

/**
 * Contao Open Source CMS
 * Copyright (C) 2005-2013 Leo Feyer
 *
 *
 * PHP version 5
 * @copyright  Martin Kozianka 2013-2014 <http://kozianka.de/>
 * @author     Martin Kozianka <http://kozianka.de/>
 * @package    additional_metafields
 * @license    LGPL
 * @filesource
 */

$GLOBALS['TL_HOOKS']['getContentElement'][]         = array('AdditionalMetafields\MetaFieldsHelper', 'injectMetaData');
$GLOBALS['BE_FFL']['metaWizardPlus']                = 'AdditionalMetafields\MetaWizardPlus';

if (TL_MODE == 'BE') {
    $GLOBALS['TL_CSS'][] = "/system/modules/additional_metafields/assets/style.css";
}
