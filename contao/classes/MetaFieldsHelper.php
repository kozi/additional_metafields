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


/**
 * Run in a custom namespace, so the class can be replaced
 */
namespace AdditionalMetafields;

/**
 * Class MetaFieldsHelper
 *
 * Provides some helper functions
 * @copyright  Martin Kozianka 2013-2014 <http://kozianka.de/>
 * @author     Martin Kozianka <http://kozianka.de/>
 * @package    additional_metafields
 */
class MetaFieldsHelper extends \Frontend {

    public static function getFileExtensions() {
        $exts = array();
        if (array_key_exists('additional_metafields_exts', $GLOBALS['TL_CONFIG'])
            && strlen($GLOBALS['TL_CONFIG']['additional_metafields_exts']) > 0) {
            $exts = explode(',', $GLOBALS['TL_CONFIG']['additional_metafields_exts']);
            $exts = array_map('trim', $exts);
        }
        return $exts;
    }

    public static function getFields() {
        if (!array_key_exists('additional_metafields', $GLOBALS['TL_LANG']) || count($GLOBALS['TL_LANG']['additional_metafields']) < 1) {
            return null;
        }
        return $GLOBALS['TL_LANG']['additional_metafields'];
    }

    public function injectMetaData($objRow, $strBuffer, $objElement)    {
        global $objPage;

        if (!in_array($objRow->type, array('image', 'gallery'))) {
            return $strBuffer;
        }

        if ($objRow->type === 'gallery') {
            $objElement->__set('metaData', $this->getMultiMetaData($objRow->multiSRC));
            $strBuffer = $objElement->generate();
        }

        if ($objRow->type === 'image') {
            $objFile = \FilesModel::findByUuid($objRow->singleSRC);
            $objElement->__set('singleSRC', $objFile->uuid);
            $objElement->__set('metaData', $this->getMetaData($objFile->meta, $objPage->language));

            $strBuffer = $objElement->generate();
        }

        return $strBuffer;
    }

    private function getMultiMetaData($multiSRC) {
        global $objPage;
        $images   = array();
        $objFiles = \FilesModel::findMultipleByUuids(unserialize($multiSRC));

        while ($objFiles->next()) {
            // Continue if the files has been processed or does not exist
            if (isset($images[$objFiles->path]) || !file_exists(TL_ROOT . '/' . $objFiles->path)) {
                continue;
            }
            // Single files
            if ($objFiles->type == 'file') {
                $objFile = new \File($objFiles->path, true);
                if (!$objFile->isGdImage) {
                    continue;
                }
                $images[$objFiles->path] = $this->getMetaData($objFiles->meta, $objPage->language);
            }
            else {
                $objSubfiles = \FilesModel::findByPid($objFiles->uuid);
                if ($objSubfiles === null) {
                    continue;
                }
                while ($objSubfiles->next()) {
                    // Skip subfolders
                    if ($objSubfiles->type == 'folder') {
                        continue;
                    }
                    $objFile = new \File($objSubfiles->path, true);

                    if (!$objFile->isGdImage) {
                        continue;
                    }
                    $images[$objFile->path] = $this->getMetaData($objSubfiles->meta, $objPage->language);
                }
            }
        }
        return $images;
    }

    public static function embedData($body, $metaData) {
        foreach ($body as $class => &$row) {
            foreach ($row as &$col) {
                if (array_key_exists($col->singleSRC, $metaData) && sizeof($metaData[$col->singleSRC]) > 0) {
                    $col->metaData = $metaData[$col->singleSRC];
                }
            }
        }
        return $body;
    }
} 