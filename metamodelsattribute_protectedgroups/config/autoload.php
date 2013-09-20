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
 * Register the classes
 */
ClassLoader::addClasses(array
(
	'MetaModels\Attribute\ProtectedGroups\ProtectedGroups'        => 'system/modules/metamodelsattribute_protectedgroups/MetaModels/Attribute/ProtectedGroups/ProtectedGroups.php',
	'MetaModels\Filter\Setting\Published\CheckboxMemberGroups'    => 'system/modules/metamodelsattribute_protectedgroups/MetaModels/Filter/Setting/Published/CheckboxMemberGroups.php',
	'MetaModels\Helper\CheckboxMemberGroups\CheckboxMemberGroups' => 'system/modules/metamodelsattribute_protectedgroups/MetaModels/Helper/CheckboxMemberGroups/CheckboxMemberGroups.php'

));


/**
 * Register the templates
 */
TemplateLoader::addFiles(array
(
	'mm_attr_protectedgroups' => 'system/modules/metamodelsattribute_protectedgroups/templates',
));
