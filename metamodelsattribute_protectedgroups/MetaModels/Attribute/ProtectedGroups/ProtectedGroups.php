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

namespace MetaModels\Attribute\ProtectedGroups;

use MetaModels\Attribute\BaseSimple;

/**
 * This is the MetaModel attribute class for handling checkbox fields with member groups as its content.
 *
 * @package    MetaModels
 * @subpackage AttributeProtectedGroups
 * @author     Richard Henkenjohann
 */
class ProtectedGroups extends BaseSimple
{
	/**
	 * {@inheritdoc}
	 */
	public function getSQLDataType()
	{
		return 'text NULL';
	}

	/**
	 * {@inheritdoc}
	 */
	public function getAttributeSettingNames()
	{
		return array_merge(parent::getAttributeSettingNames(), array
		(
			'filterable',
			'searchable',
			'mandatory',
		));
	}

	/**
	 * {@inheritdoc}
	 */
	public function getFieldDefinition($arrOverrides = array())
	{
		$arrFieldDef = parent::getFieldDefinition($arrOverrides);

		$arrFieldDef['inputType']        = 'checkbox';
		$arrFieldDef['foreignKey']       = 'tl_member_group.name';
		$arrFieldDef['relation']         = array('type'=>'hasMany', 'load'=>'lazy');
		$arrFieldDef['eval']['multiple'] = true;

		return $arrFieldDef;
	}
}
