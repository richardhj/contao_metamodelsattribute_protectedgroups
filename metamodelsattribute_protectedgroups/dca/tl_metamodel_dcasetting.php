<?php

/**
 * The MetaModels extension allows the creation of multiple collections of custom items,
 * each with its own unique set of selectable attributes, with attribute extendability.
 * The Front-End modules allow you to build powerful listing and filtering of the
 * data in each collection.
 *
 * PHP version 5
 * @package    MetaModels
 * @subpackage AttributeProtectedGroups
 * @author     Richard Henkenjohann
 * @copyright  Richard Henkenjohann 2013
 * @license    LGPL
 * @filesource
 */

$GLOBALS['TL_DCA']['tl_metamodel_dcasetting']['metasubselectpalettes']['attr_id']['protectedgroups'] = array
(
	'presentation' => array(
		'tl_class',
	),
	'functions'  => array(
		'mandatory',
	)
);
