<?php

use \AdditionalMetafields\MetafieldsModel;

class MetafieldsRunonceJob extends \Controller {

    public function __construct() {
        parent::__construct();
        $this->import('Database');
    }

    public function run() {
        require_once(TL_ROOT.'/system/config/langconfig.php');

        if ($this->Database->tableExists('tl_metafields')) {
            return false;
        }

        if (!is_array($GLOBALS['TL_LANG']['additional_metafields'])) {
            return false;
        }

        if (!array_key_exists('additional_metafields_exts', $GLOBALS['TL_CONFIG'])) {
            return false;
        }

        if (strlen($GLOBALS['TL_CONFIG']['additional_metafields_exts']) === 0) {
            return false;
        }

        $exts   = $GLOBALS['TL_CONFIG']['additional_metafields_exts'];
        $dcaExt = new DcaExtractor('tl_metafields');
        $arrSql = $dcaExt->getDbInstallerArray();
        $strSql = "CREATE TABLE `tl_metafields` ("
            .implode(',', $arrSql["TABLE_FIELDS"]).','
            .implode(',', $arrSql["TABLE_CREATE_DEFINITIONS"]).')'
            .$arrSql["TABLE_OPTIONS"].';';
        $this->Database->execute($strSql);

        foreach($GLOBALS['TL_LANG']['additional_metafields'] as $alias => $label) {
            $objModel = new MetafieldsModel();
            $objModel->tstamp     = time();
            $objModel->alias      = $alias;
            $objModel->label      = $label;
            $objModel->extensions = $exts;
            $objModel->save();
        }
    }
}

$objMetafieldsRunonceJob = new MetafieldsRunonceJob();
$objMetafieldsRunonceJob->run();



