<?php
/**
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 *
 *
 * @copyright     Copyright 2010, Dreaming Mind (http://dreamingmind.org)
 * @link          http://dreamingmind.com
 * @package       bindery
 * @subpackage    bindery.helper
 */
class MenuHelper extends AppHelper {
	var $helpers = array('Html');
        //var $depth = 0; //keep track of nest depth to set li class
        var $menuArray = array();
        var $liveNodes = array();
        var $menuHTML = '';
        var $route = DS;

        function __construct() {
		parent::__construct();
	}
	
	function NavigationMenu($data, $liveNodes) {
            ////$data is passed in as a reference. any changes to it here will be seen by the calling code in the array
            $this->menuArray = $data;
            $this->liveNodes = $liveNodes;
            $this->getNavigationMenu(0, $this->route);

            /*
             * Now set the individual LI class attributes to show open and active submenus
             * This make a lot of assumptions about the purity of the menu structure, no anomoly/error trapping here!
             */
            $dom = new DOMDocument();
            $dom->loadXML($this->menuHTML);
            $domUL = $dom->getElementsByTagName('ul');
            $parentClass = '';
            $x = $domUL->item(0);
            $this->walkUL($x, $parentClass);

            return $dom->saveHTML();

	}
        
        function walkUL($node, $parentClass) {
            // should arrive with a UL node in hand
            if ($node->hasChildNodes()) {
                foreach ($node->childNodes as $li) {
                    // scan through children looking for LI nodes
                    if ($li->nodeType == XML_ELEMENT_NODE) {
                        $pClass = $li->attributes->getNamedItem('class')->nodeValue;
                        if ($pClass == 'open' || $pClass == 'active' ) {
                            // 'open' or 'active' LIs means a sub-menu might be exposed
                            foreach ($li->childNodes as $ul) {
                                if ($ul->nodeType == XML_ELEMENT_NODE && $ul->tagName == 'ul') {
                                    // if we find a sub-menu UL then recurse to process it
                                    $this->walkUL($ul, $pClass);
                                }
                            }
                        } else {
                            // tweak the LI class names for exposed sub-menus
                            $li->attributes->getNamedItem('class')->nodeValue .= $parentClass;
                        }
                    }
                }
            }
        }

        function getNavigationMenu($key, $route) {

            $this->menuHTML .= "\n<ul>\n";
            if (is_array($this->menuArray[$key])) {
                foreach($this->menuArray[$key] as $levelKey => $entry) {
                    $this->getMenuLine($levelKey, $entry, $route);
                }
            }
            $this->menuHTML .= "</ul>\n";

	}
	
	function getMenuLine($key, $entry, $route) {

            $link = $this->Html->link($entry['Navline']['name'], $route . DS . $entry['Navline']['route']);//array('controller'=>'product', $entry['Navline']['route'])
            $id = $key; //

            //if the current entries 'route' field matches one of the url parameters
            if (isset($this->liveNodes[$entry['Navline']['route']])) {

                // there may have been earlier matches. Mark them 'open' rather than 'active'                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                              
                $this->menuHTML = str_replace(' class="active"', ' class="open"', $this->menuHTML);
                // and make this one the new 'active' item
                $this->menuHTML .= $this->Html->tag('li', null, array('class' => 'active', 'id' => $id));
                // and send this route out for 'splash page' analysis
//                $this->activeRoute = $entry['Navline']['route'];
//                $this->set('activeRoute',$this->activeRoute);
//                $this->params['activeRoute'] = $entry['Navline']['route'];
//                debug($this->params);
                $this->menuHTML .= $link;
                // This will drill down to a deeper nest if it exists
                if(array_key_exists($key, $this->menuArray)) {
                    $this->getNavigationMenu($key, $route . "/" . $entry['Navline']['route']);
                }

            } else {
                    $this->menuHTML .= $this->Html->tag('li', null, array('class' => 'menu', 'id' => $id));
                    $this->menuHTML .= $link;
            }

            $this->menuHTML .= "</li>\n";
	}

}
?>
