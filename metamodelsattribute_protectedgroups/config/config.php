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

$GLOBALS['METAMODELS']['attributes']['protectedgroups']['class'] = 'MetaModels\Attribute\ProtectedGroups\ProtectedGroups';
$GLOBALS['METAMODELS']['attributes']['protectedgroups']['image'] = 'system/modules/metamodelsattribute_protectedgroups/html/protected.png';

$GLOBALS['METAMODELS']['filters']['checkbox_publishedByMemberGroups']['class']         = 'MetaModels\Filter\Setting\Published\CheckboxMemberGroups';
$GLOBALS['METAMODELS']['filters']['checkbox_publishedByMemberGroups']['image']         = 'system/modules/metamodels/html/visible.png';
$GLOBALS['METAMODELS']['filters']['checkbox_publishedByMemberGroups']['info_callback'] = array('MetaModels\Helper\CheckboxMemberGroups\CheckboxMemberGroups', 'drawPublishedSetting');
$GLOBALS['METAMODELS']['filters']['checkbox_publishedByMemberGroups']['attr_filter'][] = 'protectedgroups';

// non composerized Contao 2.X autoload support.
$GLOBALS['MM_AUTOLOAD'][] = dirname(__DIR__);
