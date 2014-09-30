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
 * Class MetaWizardPlus
 *
 * Extends the MetaWizard class
 * @copyright  Martin Kozianka 2013-2014 <http://kozianka.de/>
 * @author     Martin Kozianka <http://kozianka.de/>
 * @package    additional_metafields
 */
class MetaWizardPlus extends \MetaWizard {
    /**
     * Generate the widget and return it as string
     * @return string
     */
    public function generate() {
        $helper         = MetafieldsHelper::getInstance();
        $metafieldsPlus = $helper->getFields($this->activeRecord);

        if ($metafieldsPlus === null) {
            return parent::generate();
        }

        // Make sure there is at least an empty array
        if (!is_array($this->varValue) || empty($this->varValue))
        {
            $this->import('Contao\BackendUser', 'User');
            $this->varValue = array($this->User->language=>array()); // see #4188
        }

        $count = 0;
        $languages = $this->getLanguages();
        $taken = array();

        // Add the existing entries
        if (!empty($this->varValue))
        {
            $return = '<ul id="ctrl_'.$this->strId.'" class="tl_metawizard tl_metawizard_plus">';

            // Add the input fields
            foreach ($this->varValue as $lang=>$meta)
            {
                $return .= '<li class="'.(($count%2 == 0) ? 'even' : 'odd').'" data-language="' . $lang . '">';
                $return .= '<span class="lang">' . $languages[$lang] . ' ' . \Image::getHtml('delete.gif', '', 'class="tl_metawizard_img" onclick="Backend.metaDelete(this)" title="'.specialchars($GLOBALS['TL_LANG']['MSC']['aw_delete']).'"') . '</span>';
                $return .= '<label for="ctrl_title_'.$count.'">'.$GLOBALS['TL_LANG']['MSC']['aw_title'].'</label> <input type="text" name="'.$this->strId.'['.$lang.'][title]" id="ctrl_title_'.$count.'" class="tl_text" value="'.specialchars($meta['title']).'"><br>';
                $return .= '<label for="ctrl_link_'.$count.'">'.$GLOBALS['TL_LANG']['MSC']['aw_link'].'</label> <input type="text" name="'.$this->strId.'['.$lang.'][link]" id="ctrl_link_'.$count.'" class="tl_text" value="'.specialchars($meta['link']).'"><br>';
                $return .= '<label for="ctrl_caption_'.$count.'">'.$GLOBALS['TL_LANG']['MSC']['aw_caption'].'</label> <input type="text" name="'.$this->strId.'['.$lang.'][caption]" id="ctrl_caption_'.$count.'" class="tl_text" value="'.specialchars($meta['caption']).'">';

                // PlusFields
                foreach ($metafieldsPlus as $fieldname => $label) {
                    $return .= '<label class="tl_metafields" for="ctrl_'.$fieldname.'_'.$count.'">'.$label.'</label> <input type="text" name="'.$this->strId.'['.$lang.']['.$fieldname.']" id="ctrl_'.$fieldname.'_'.$count.'" class="tl_text tl_metafields" value="'.specialchars($meta[$fieldname]).'"><br>';
                }
                $return .= '</li>';

                $taken[] = $lang;
                ++$count;
            }

            $return .= '</ul>';
        }

        $options = array('<option value="">-</option>');

        // Add the remaining languages
        foreach ($languages as $k=>$v)
        {
            $options[] = '<option value="' . $k . '"' . (in_array($k, $taken) ? ' disabled' : '') . '>' . $v . '</option>';
        }

        $return .= '
  <div class="tl_metawizard_new">
    <select name="'.$this->strId.'[language]" class="tl_select tl_chosen" onchange="Backend.toggleAddLanguageButton(this)">'.implode('', $options).'</select> <input type="button" class="tl_submit" disabled value="'.specialchars($GLOBALS['TL_LANG']['MSC']['aw_new']).'" onclick="Backend.metaWizard(this,\'ctrl_'.$this->strId.'\')">
  </div>';

        return $return;
    }
}


