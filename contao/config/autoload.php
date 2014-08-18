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



ClassLoader::addNamespace('AdditionalMetafields');

ClassLoader::addClasses(array(
    'AdditionalMetafields\MetaFieldsHelper'          => 'system/modules/additional_metafields/classes/MetaFieldsHelper.php',
    'AdditionalMetafields\MetaWizardPlus'            => 'system/modules/additional_metafields/widgets/MetaWizardPlus.php'
));
