<?php

/**
 * Contao Open Source CMS
 * Copyright (C) 2005-2014 Leo Feyer
 *
 *
 * PHP version 5
 * @copyright  Martin Kozianka 2013-2014 <http://kozianka.de/>
 * @author     Martin Kozianka <http://kozianka.de/>
 * @package    additional_metafields
 * @license    LGPL
 * @filesource
 */

$GLOBALS['TL_HOOKS']['getContentElement'][]         = array('AdditionalMetafields\MetafieldsHelper', 'injectMetaData');
$GLOBALS['TL_HOOKS']['parseArticles'][]             = array('AdditionalMetafields\MetafieldsHelper', 'injectMetaDataArticleImage');

$GLOBALS['BE_FFL']['metaWizardPlus']                = 'AdditionalMetafields\MetaWizardPlus';
$GLOBALS['TL_MODELS']['tl_metafields']              = 'AdditionalMetafields\MetafieldsModel';

array_insert($GLOBALS['BE_MOD']['system'], 1, array(
    'metafields' => array
    (
        'tables'     => array('tl_metafields'),
        'icon'       => 'system/modules/metafields/assets/document-stamp.png'
    )
));

if (TL_MODE == 'BE') {
    $GLOBALS['TL_CSS'][] = "/system/modules/metafields/assets/style.css";
}

