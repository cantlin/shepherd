<?php

// $properties = array(
		    array(
			  'name' => 'tpl',
			  'desc' => 'prop_shepherd.tpl_desc',
			  'type' => 'textfield',
			  'options' => '',
			  'value' => 'rowTpl',
			  'lexicon' => 'shepherd:properties',
			  ),
		    array(
			  'name' => 'sort',
			  'desc' => 'prop_shepherd.sort_desc',
			  'type' => 'textfield',
			  'options' => '',
			  'value' => 'name',
			  'lexicon' => 'shepherd:properties',
			  ),
		    array(
			  'name' => 'dir',
			  'desc' => 'prop_shepherd.dir_desc',
			  'type' => 'list',
			  'options' => array(
					     array('text' => 'prop_shepherd.ascending','value' => 'ASC'),
					     array('text' => 'prop_shepherd.descending','value' => 'DESC'),
					     ),
			  'value' => 'DESC',
			  'lexicon' => 'shepherd:properties',
			  ),
		    );

// return $properties;