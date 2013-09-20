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

/**
 * Table tl_metamodel_filtersetting
 */
$GLOBALS['TL_DCA']['tl_metamodel_filtersetting']['metapalettes']['checkbox_publishedByMemberGroups extends _attribute_']['+config'] = array('check_ignorepublished', 'check_allowpreview');
