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

$GLOBALS['TL_DCA']['tl_settings']['palettes']['default'] .= ';{additional_metafields_legend:hide},additional_metafields_exts';

$GLOBALS['TL_DCA']['tl_settings']['fields']['additional_metafields_exts'] = array(
    'label'             => &$GLOBALS['TL_LANG']['tl_settings']['additional_metafields_exts'],
    'inputType'         => 'text'
);