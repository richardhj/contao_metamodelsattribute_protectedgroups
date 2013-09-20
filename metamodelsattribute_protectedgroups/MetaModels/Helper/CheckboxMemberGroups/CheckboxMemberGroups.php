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

namespace MetaModels\Helper\CheckboxMemberGroups;

use DcGeneral\DataContainerInterface;
use MetaModels\Factory;
use MetaModels\Dca\Filter;

/**
 * This class is used from checkbox attributes for button callbacks etc.
 *
 * @package    MetaModels
 * @subpackage AttributeCheckbox
 * @author     Christian Schiffler <c.schiffler@cyberspectrum.de>
 */
class CheckboxMemberGroups extends \Backend
{
	/**
	 * Render a row for the list view in the backend.
	 *
	 * @param array  $arrRow   the current data row.
	 *
	 * @param        $strHref
	 *
	 * @param string $strLabel the label text.
	 *
	 * @param        $strTitle
	 *
	 * @param        $strIcon
	 *
	 * @param        $strAttributes
	 *
	 * @return string
	 */
	public function toggleIcon($arrRow, $strHref, $strLabel, $strTitle, $strIcon, $strAttributes)
	{
		if (preg_match('#attribute=([^&$]*)#', $strHref, $arrMatch))
		{
			if ($arrRow[$arrMatch[1]])
			{
				$strNewState = '0';
			} else {
				$strNewState = '1';
				// makes invisible out of visible
				$strIcon = 'in' . $strIcon;
			}

			$strImg = $this->generateImage($strIcon, $strLabel);


			return "\n\n" . sprintf('<a href="%s" title="%s"%s>%s</a> ',
				$this->addToUrl($strHref . sprintf('&amp;tid=%s&amp;state=%s', $arrRow['id'], $strNewState)),
				specialchars($strTitle),
				$strAttributes,
				$strImg?$strImg:$strLabel
			) . "\n\n";
		}
	}

	public function checkToggle($objDC)
	{
		if (\Input::getInstance()->get('action') != 'publishtoggle')
		{
			return;
		}
		// TODO: check if the attribute is allowed to be edited by the current backend user
		$strAttribute = \Input::getInstance()->get('attribute');
		if(($objMetaModel = Factory::byTableName(\Input::getInstance()->get('metamodel')))
			&& ($objAttribute = $objMetaModel->getAttribute($strAttribute)))
		{
			if (!($intId = intval(\Input::getInstance()->get('tid'))))
			{
				return;
			}
			$strState = \Input::getInstance()->get('state')=='1'?'1':'';

			$arrIds = array($intId => $strState);
			// determine variants.
			if ($objMetaModel->hasVariants() && !$objAttribute->get('isvariant'))
			{
				if (!($objItem = $objMetaModel->findById($intId)))
				{
					return;
				}

				if ($objItem->isVariantBase())
				{
					$objChilds = $objItem->getVariants(null);
					foreach ($objChilds as $objItem)
					{
						$arrIds[intval($objItem->get('id'))] = $strState;
					}
				}
			}

			// TODO: replace with $objAttribute->setData(); call when simple attributes also have a setData and getData option.
			// Update database
			\Database::getInstance()->prepare(sprintf(
				'UPDATE %s SET %s=? WHERE id IN (%s)',
				$objMetaModel->getTableName(),
				$objAttribute->getColName(),
				implode(',', array_keys($arrIds))
			))
				->execute(\Input::getInstance()->get('state')=='1'?'1':'');
			exit;
		}
	}

	public function drawPublishedSetting($arrRow, $strLabel, DataContainerInterface $objDC = null, $imageAttribute='', $strImage)
	{
		$objMetaModel = Filter::getInstance()->getMetaModel($objDC);

		$objAttribute = $objMetaModel->getAttributeById($arrRow['attr_id']);

		if ($objAttribute)
		{
			$strAttrName = $objAttribute->getName();
			$strAttrColName = $objAttribute->getColName();
		} else {
			$strAttrName = $arrRow['attr_id'];
			$strAttrColName = $arrRow['attr_id'];
		}

		if (!empty($arrRow['comment']))
		{
			$arrRow['comment'] = sprintf($GLOBALS['TL_LANG']['tl_metamodel_filtersetting']['typedesc']['_comment_'], $arrRow['comment']);
		}

		$strReturn = sprintf(
			$GLOBALS['TL_LANG']['tl_metamodel_filtersetting']['typedesc']['checkbox_published'],
			'<a href="' . $this->addToUrl('act=edit&amp;id='.$arrRow['id']). '">' . $strImage . '</a>',
			$strLabel ? $strLabel : $arrRow['type'],
			$arrRow['comment'],
			$strAttrName
		);
		return $strReturn;
	}
}
