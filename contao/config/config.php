<?php

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

$GLOBALS['TL_HOOKS']['getContentElement'][] = ['\Metafields\MetafieldsHelper', 'injectMetaData'];
$GLOBALS['TL_HOOKS']['parseArticles'][]     = ['\Metafields\MetafieldsHelper', 'injectMetaDataArticleImage'];

$GLOBALS['BE_FFL']['metaWizardPlus']        = '\Metafields\Widgets\MetaWizardPlus';
$GLOBALS['TL_MODELS']['tl_metafields']      = '\Metafields\Models\MetafieldsModel';

array_insert($GLOBALS['BE_MOD']['system'], 1, [
    'metafields' => [
        'tables'     => ['tl_metafields'],
        'icon'       => 'system/modules/metafields/assets/document-stamp.png'
    ]
]);

if (TL_MODE === 'BE')
{
    $GLOBALS['TL_CSS'][] = "/system/modules/metafields/assets/style.css";
}

