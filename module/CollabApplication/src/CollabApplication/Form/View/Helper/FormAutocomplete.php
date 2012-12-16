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

use Zend\I18n\View\Helper\AbstractTranslatorHelper;

class FormAutocomplete extends AbstractTranslatorHelper
{
	public function __invoke($collection, array $options)
	{
        $view = $this->getView();
        $view->headScript()->appendFile($view->basePath() . '/js/autocomplete.js');
        $view->headLink()->appendStylesheet($view->basePath() . '/css/autocomplete.css');

        $targetElement= $collection->getTargetElement();
        $elements = $targetElement->getElements();
        $keyName = key($elements);
        next($elements);
        $lblName = key($elements);

        $keyFunc = 'get' . ucfirst($keyName);
        $lblFunc = 'get' . ucfirst($lblName);

        $list = '<ul class="pills">';
        foreach ($collection->getObject() as $i => $object) {
            $key = call_user_func(array($object, $keyFunc));
            $lbl = call_user_func(array($object, $lblFunc));

            $list .= '<li>';
            $list .= '<input type="hidden" name="' . $collection->getName() . '[' . $i . '][' . $keyName . ']" value="' . $key . '" />';
            $list .= '<span>' . $lbl . '</span> ';
            $list .= '<a href="" class="remove action">(remove)</a>';
            $list .= '</li>';
        }
        $list .= '</ul>';

		$result = '<div class="autocomplete">';
		$result .= '<h2>' . $collection->getLabel() . '</h2>';
        $result .= '<div class="fields">
            ' . $list . '

            <div class="add-pill-form">
                <input type="text" class="listener"
                    data-url="' . $options['url'] . '"
                    data-key="' . $options['key'] . '"
                    data-lbl="' . $options['lbl'] . '"
                    data-name="' . $collection->getName() . '" />
                <ul class="results"></ul>
                <button class="mini" type="submit">Add</button>
            </div>
        </div>';
		$result .= '</div>';
		return $result;
	}
}
