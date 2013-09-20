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

namespace MetaModels\Filter\Setting\Published;

use MetaModels\Filter\Setting\Simple;
use MetaModels\Filter\IFilter;
use MetaModels\Filter\Rules\SimpleQuery;
use MetaModels\Filter\Rules\StaticIdList;

class CheckboxMemberGroups extends Simple
{
	/**
	 * {@inheritdoc}
	 */
	public function prepareRules(IFilter $objFilter, $arrFilterUrl)
	{
		if ($this->get('check_ignorepublished') && $arrFilterUrl['ignore_published' . $this->get('id')])
		{
			return;
		}

		// Skip filter when in front end preview.
		if ($this->get('check_allowpreview') && BE_USER_LOGGED_IN)
		{
			return;
		}

		$objAttribute = $this->getMetaModel()->getAttributeById($this->get('attr_id'));

		if ($objAttribute)
		{
			// Check which metamodels are open to the logged in user
			$arrSets = array();
			$objDatabase = \Database::getInstance()->query('SELECT id,groups FROM ' . $this->getMetaModel()->getTableName());

			while ($objDatabase->next())
			{
				$groups = deserialize($objDatabase->groups);

				if (!is_array($groups) || empty($groups) || count(array_intersect(\FrontendUser::getInstance()->groups, $groups)))
				{
					$arrSets[] = $objDatabase->id;
				}
			}

			// Use SimpleQuery for the filter rule
			$objFilterRule = new SimpleQuery(sprintf(
				'SELECT id FROM %s WHERE id IN (%s)',
				$this->getMetaModel()->getTableName(),
				implode(', ', $arrSets)
			));
			$objFilter->addFilterRule($objFilterRule);

			return;
		}
		// no attribute found, do not return anyting.
		$objFilter->addFilterRule(new StaticIdList(array()));
	}

	/**
	 * {@inheritdoc}
	 */
	public function getParameters()
	{
		return ($this->get('check_ignorepublished')) ? array('ignore_published' . $this->get('id')) : array();
	}

	/**
	 * {@inheritdoc}
	 */
	public function getParameterDCA()
	{
		if (!$this->get('check_ignorepublished'))
		{
			return array();
		}

		$objAttribute = $this->getMetaModel()->getAttributeById($this->get('attr_id'));

		$arrLabel = array();
		foreach ($GLOBALS['TL_LANG']['MSC']['metamodel_filtersetting']['ignore_published'] as $strLabel)
		{
			$arrLabel[] = sprintf($strLabel, $objAttribute->getName());
		}

		return array(
			'ignore_published' . $this->get('id') => array
			(
				'label'   => $arrLabel,
				'inputType'    => 'checkbox',
			)
		);
	}
}
