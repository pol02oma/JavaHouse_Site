<?php
/*------------------------------------------------------------------------
# mod_otweets - Optimized Tweets

# ------------------------------------------------------------------------

# author:    Optimized Sense

# copyright: Copyright (C) 2011 http://www.o-sense.com. All Rights Reserved.

# @license: http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL

# Websites: http://www.o-sense.com

# Technical Support:  http://www.o-sense.com/contact-us/support-inquiries.html

-------------------------------------------------------------------------*/

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

require_once dirname(__FILE__) . '/helper.php';

$data = oTweets::getData($params);

require(JModuleHelper::getLayoutPath('mod_otweets'));
