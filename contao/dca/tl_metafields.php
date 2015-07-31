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

$GLOBALS['TL_DCA']['tl_metafields'] = [

    // Config
    'config' => [
        'dataContainer'               => 'Table',
        'enableVersioning'            => true,
        'sql' => ['keys' => ['id' => 'primary']]
    ],

    // List
    'list' => [
        'sorting' => [
            'fields'                  => ['label'],
            'flag'                    => 1,
        ],
        'label' => [
            'fields'                  => ['label', 'alias', 'extensions', 'folder'],
            'showColumns'             => true,
        ],
        'global_operations' => [
            'all' => [
                'label'               => &$GLOBALS['TL_LANG']['MSC']['all'],
                'href'                => 'act=select',
                'class'               => 'header_edit_all',
                'attributes'          => 'onclick="Backend.getScrollOffset();"'
            ]
        ],
        'operations' => [
            'edit' => [
                'label'               => &$GLOBALS['TL_LANG']['tl_metafields']['edit'],
                'href'                => 'act=edit',
                'icon'                => 'edit.gif'
            ],
            'delete' => [
                'label'               => &$GLOBALS['TL_LANG']['tl_metafields']['delete'],
                'href'                => 'act=delete',
                'icon'                => 'delete.gif',
                'attributes'          => 'onclick="if (!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\')) return false; Backend.getScrollOffset();"'
            ]
        ]
    ],

    // Palettes
    'palettes' => [
        'default'					=> '{metafields_legend}, alias, label, extensions, folder;',
    ],

    // Fields
    'fields' => [
        'id' => [
            'label'                   => ['ID'],
            'search'                  => false,
            'sql'                     => "int(10) unsigned NOT NULL auto_increment"
        ],
        'tstamp' => [
            'label'                   => ['TSTAMP'],
            'search'                  => false,
            'sql'                     => "int(10) unsigned NOT NULL default '0'",
        ],
        'label' => [
            'label'                   => &$GLOBALS['TL_LANG']['tl_metafields']['label'],
            'exclude'                 => true,
            'flag'                    => 1,
            'inputType'               => 'text',
            'eval'                    => ['mandatory'=>true, 'tl_class' => 'w50'],
            'sql'                     => "varchar(255) NOT NULL default ''",
        ],
        'alias' => [
            'label'                   => &$GLOBALS['TL_LANG']['tl_metafields']['alias'],
            'exclude'                 => true,
            'flag'                    => 1,
            'inputType'               => 'text',
            'eval'                    => ['doNotCopy'=>true, 'maxlength'=>128, 'tl_class'=>'w50'],
            'save_callback'           => [['tl_metafields', 'generateAlias']],
            'sql'                     => "varchar(128) COLLATE utf8_bin NOT NULL default ''"
        ],
        'extensions' => [
            'label'                   => &$GLOBALS['TL_LANG']['tl_metafields']['extensions'],
            'exclude'                 => true,
            'flag'                    => 1,
            'inputType'               => 'text',
            'eval'                    => ['mandatory'=>false, 'tl_class' => 'w50'],
            'sql'                     => "varchar(255) NOT NULL default ''",
        ],
        'folder' => [
            'label'                   => &$GLOBALS['TL_LANG']['tl_metafields']['folder'],
            'exclude'                 => true,
            'flag'                    => 1,
            'inputType'               => 'checkbox',
            'eval'                    => ['mandatory'=>false, 'tl_class' => 'w50 m12'],
            'sql'                     => "char(1) NOT NULL default ''",
        ],
    ]
];


/**
 * Class tl_metafields
 *
 * Provide miscellaneous methods that are used by the data configuration array.
 * @copyright  Martin Kozianka 2013-2015
 * @author     Martin Kozianka <http://kozianka.de/>
 * @package    contao-metafields
 */

class tl_metafields extends Backend
{
    public function generateAlias($varValue, DataContainer $dc)
    {
        // Generate an alias if there is none
        if ($varValue == '')
        {
            $varValue  = standardize(String::restoreBasicEntities($dc->activeRecord->label));
        }

        $objAlias = $this->Database->prepare("SELECT id FROM tl_metafields WHERE id=? OR alias=?")
            ->execute($dc->id, $varValue);

        // Check whether the alias exists
        if ($objAlias->numRows > 1)
        {
            throw new Exception(sprintf($GLOBALS['TL_LANG']['ERR']['aliasExists'], $varValue));
        }
        return $varValue;
    }

}

