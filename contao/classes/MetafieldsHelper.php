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

namespace AdditionalMetafields;

/**
 * Class MetafieldsHelper
 *
 * Provides some helper functions
 * @copyright  Martin Kozianka 2013-2014 <http://kozianka.de/>
 * @author     Martin Kozianka <http://kozianka.de/>
 * @package    additional_metafields
 */

class MetafieldsHelper extends \Frontend {

    const TYPE_FOLDER      = '__TYPE_FOLDER__';

    private $arrMetafields = null;


    /**
     * @var MetafieldsHelper
     */
    protected static $instance;

    /**
     * Instantiate the MetafieldsHelper object (Factory)
     *
     * @return MetafieldsHelper The MetafieldsHelper object
     */
    static public function getInstance() {

        if (static::$instance === null) {
            static::$instance = new static();
        }

        return static::$instance;
    }

    public function getFields($activeRecord) {
        $arrMetafields = $this->loadFields();
        $strType       = ($activeRecord->type !== 'folder') ? $activeRecord->extension : self::TYPE_FOLDER;

        if (!array_key_exists($strType, $arrMetafields) ) {
            return null;
        }

        return $arrMetafields[$strType];
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

    public function injectMetaDataArticleImage(&$objTmpl, $row, $obj) {
        global $objPage;

        $objFile           = \FilesModel::findByUuid($row['singleSRC']);
        $objTmpl->metadata = $this->getMetaData($objFile->meta, $objPage->language);
    }

    private function getMultiMetaData($multiSRC) {


        global $objPage;
        $images   = array();
        $objFiles = \FilesModel::findMultipleByUuids(unserialize($multiSRC));

        if($objFiles !== null) {
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
                } else {
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
        } // END if($objFiles !== null)
        return $images;
    }

    public static function embedData(&$body, $metaData) {
        foreach($body as $class => $row) {
            foreach($row as $key => $col) {
                if (array_key_exists($col->singleSRC, $metaData) && sizeof($metaData[$col->singleSRC]) > 0) {
                    $body[$class][$key]->metaData = $metaData[$col->singleSRC];
                }
            }
        }
        return $body;
    }

    private function loadFields() {
        if($this->arrMetafields !== null) {
            return $this->arrMetafields;
        }
        $this->arrMetafields = array();
        // Todo label translation
        $collection = MetafieldsModel::findAll();

        if ($collection === null) {
            return $this->arrMetafields;
        }

        foreach($collection as $objField) {
            $extensions = array_map('trim', explode(',', $objField->extensions));
            $alias      = $objField->alias;
            $label      = $objField->label;
            $folderAttr = ($objField->folder === '1');

            foreach($extensions as $ext) {
                if (!is_array($this->arrMetafields[$ext])) {
                    $this->arrMetafields[$ext] = array();
                }
                $this->arrMetafields[$ext][$alias] = $label;

                if ($folderAttr) {
                    if (!is_array($this->arrMetafields[static::TYPE_FOLDER])) {
                        $this->arrMetafields[static::TYPE_FOLDER] = array();
                    }
                    $this->arrMetafields[static::TYPE_FOLDER][$alias] = $label;
                }
            }
        }
        return $this->arrMetafields;
    }
}


