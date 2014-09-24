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
 * Class MetafieldsModel
 *
 * Provides some helper functions
 * @copyright  Martin Kozianka 2013-2014 <http://kozianka.de/>
 * @author     Martin Kozianka <http://kozianka.de/>
 * @package    additional_metafields
 */
class MetafieldsModel extends \Model {

    protected static $strTable = 'tl_metafields';
}