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
ClassLoader::addNamespace('AdditionalMetafields');

ClassLoader::addClasses(array(
    'AdditionalMetafields\MetafieldsHelper'          => 'system/modules/metafields/classes/MetafieldsHelper.php',
    'AdditionalMetafields\MetaWizardPlus'            => 'system/modules/metafields/widgets/MetaWizardPlus.php',
    'AdditionalMetafields\MetafieldsModel'           => 'system/modules/metafields/models/MetafieldsModel.php',
));


