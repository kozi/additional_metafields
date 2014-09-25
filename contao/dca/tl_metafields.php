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

$GLOBALS['TL_DCA']['tl_metafields'] = array(

    // Config
    'config' => array
    (
        'dataContainer'               => 'Table',
        'enableVersioning'            => true,
        'sql' => array(
            'keys' => array('id' => 'primary')
        )
    ),

    // List
    'list' => array
    (
        'sorting' => array
        (
            'fields'                  => array('label'),
            'flag'                    => 1,
        ),
        'label' => array
        (
            'fields'                  => array('label', 'alias', 'extensions', 'folder'),
            'showColumns'             => true,
        ),
        'global_operations' => array
        (
            'all' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['MSC']['all'],
                'href'                => 'act=select',
                'class'               => 'header_edit_all',
                'attributes'          => 'onclick="Backend.getScrollOffset();"'
            )
        ),
        'operations' => array
        (
            'edit' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['tl_metafields']['edit'],
                'href'                => 'act=edit',
                'icon'                => 'edit.gif'
            ),
            'delete' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['tl_metafields']['delete'],
                'href'                => 'act=delete',
                'icon'                => 'delete.gif',
                'attributes'          => 'onclick="if (!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\')) return false; Backend.getScrollOffset();"'
            )
        )
    ),

    // Palettes
    'palettes' => array
    (
        'default'					=> '{metafields_legend}, alias, label, extensions, folder;',
    ),

    // Fields
    'fields' => array
    (
        'id' => array
        (
            'label'                   => array('ID'),
            'search'                  => false,
            'sql'                     => "int(10) unsigned NOT NULL auto_increment"
        ),
        'tstamp' => array
        (
            'label'                   => array('TSTAMP'),
            'search'                  => false,
            'sql'                     => "int(10) unsigned NOT NULL default '0'",
        ),
        'label' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_metafields']['label'],
            'exclude'                 => true,
            'flag'                    => 1,
            'inputType'               => 'text',
            'eval'                    => array('mandatory'=>true, 'tl_class' => 'w50'),
            'sql'                     => "varchar(255) NOT NULL default ''",
        ),
        'alias' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_metafields']['alias'],
            'exclude'                 => true,
            'flag'                    => 1,
            'inputType'               => 'text',
            'eval'                    => array('doNotCopy'=>true, 'maxlength'=>128, 'tl_class'=>'w50'),
            'save_callback' => array
            (
                array('tl_metafields', 'generateAlias')
            ),
            'sql'                     => "varchar(128) COLLATE utf8_bin NOT NULL default ''"
        ),
        'extensions' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_metafields']['extensions'],
            'exclude'                 => true,
            'flag'                    => 1,
            'inputType'               => 'text',
            'eval'                    => array('mandatory'=>false, 'tl_class' => 'w50'),
            'sql'                     => "varchar(255) NOT NULL default ''",
        ),
        'folder' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_metafields']['folder'],
            'exclude'                 => true,
            'flag'                    => 1,
            'inputType'               => 'checkbox',
            'eval'                    => array('mandatory'=>false, 'tl_class' => 'w50 m12'),
            'sql'                     => "char(1) NOT NULL default ''",
        ),

    )
);


/**
 * Class tl_metafields
 *
 * Provide miscellaneous methods that are used by the data configuration array.
 * @copyright  Martin Kozianka 2013-2014
 * @author     Martin Kozianka <http://kozianka.de/>
 * @package    additional_metafields
 */

class tl_metafields extends Backend {

    public function generateAlias($varValue, DataContainer $dc) {
        // Generate an alias if there is none
        if ($varValue == '') {
            $varValue  = standardize(String::restoreBasicEntities($dc->activeRecord->label));
        }

        $objAlias = $this->Database->prepare("SELECT id FROM tl_metafields WHERE id=? OR alias=?")
            ->execute($dc->id, $varValue);

        // Check whether the alias exists
        if ($objAlias->numRows > 1) {
            throw new Exception(sprintf($GLOBALS['TL_LANG']['ERR']['aliasExists'], $varValue));
        }
        return $varValue;
    }


}

