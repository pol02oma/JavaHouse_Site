<?php

// Set flag that this is a parent file
defined( '_JEXEC' ) or die( 'Restricted access' );

class JElementColorText extends JElement
{
	function fetchElement($name, $value, &$node, $control_name)
	{
		$document	= &JFactory::getDocument();

		// Color Picker
		JHTML::stylesheet( 'picker.css', JURI::root().'modules/mod_otweets/cp/' );
		$document->addScript(JURI::root().'modules/mod_otweets/cp/picker.js');

		$size = ( $node->attributes('size') ? 'size="'.$node->attributes('size').'"' : '' );
		$class = ( $node->attributes('class') ? 'class="'.$node->attributes('class').'"' : 'class="text_area"' );
        $onchange = ( $node->attributes('onchange') ? 'onchange="'.$node->attributes('onchange').'"' : '' );

        $value = htmlspecialchars(html_entity_decode($value, ENT_QUOTES), ENT_QUOTES);
		$value2 = '#'.$value;
        $background = ' style="background-color: '.$value2.'"';

		$html ='<input type="text" name="'.$control_name.'['.$name.']" id="'.$control_name.$name.'" value="'.$value.'" '.$class.' '.$size.' '.$background.' '.$onchange.' onfocus="this.style.background=\'#ffffff\';" />';
		
		// Color Picker
		$html .= '<span style="margin-left:10px" onclick="openPicker(\''.$control_name.$name.'\')"  class="picker_buttons">' . JText::_('Pick color') . '</span>';

	return $html;
	}
}
?>
