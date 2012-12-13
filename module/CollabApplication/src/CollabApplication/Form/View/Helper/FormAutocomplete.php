<?php
/**
 * This file is part of Collaboratory (https://github.com/pixelpolishers/collaboratory)
 *
 * @link      https://github.com/pixelpolishers/collaboratory for the canonical source repository
 * @copyright Copyright (c) 2012 Pixel Polishers (https://github.com/pixelpolishers)
 * @license   For the full copyright and license information, view the LICENSE file.
 * @package   Collaboratory
 */

namespace CollabApplication\Form\View\Helper;

use Zend\Form\Element\Collection;
use Zend\I18n\View\Helper\AbstractTranslatorHelper;

class FormAutocomplete extends AbstractTranslatorHelper
{
	public function __invoke(Collection $collection)
	{
		$result = '<div class="autocomplete">';

		$result .= '<h2>' . $collection->getLabel() . '</h2>';

		foreach ($collection as $entry) {
			$result .= $this->getView()->formElement($entry);
		}

		$result .= '</div>' . $this->getView()->formRow($collection);
		return $result;
	}
}
