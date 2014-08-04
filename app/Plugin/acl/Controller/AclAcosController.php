<?php

class AclAcosController extends AclAppController {
	var $name = 'AclAcos';

	function load($id) {
		$this->layout = '';
		$n = $this->AclAco->read(null, $id);
		$data = array(
			'id' => $n['AclAco']['id'],
			'alias' => $n['AclAco']['alias'],
			'model' => $n['AclAco']['model'],
			'key' => $n['AclAco']['foreign_key'],
			'parent_id' => $n['AclAco']['parent_id']
		);
		Configure::write('debug', 0);
		App::import('Vendor', 'Acl.json');
		$json = new Services_JSON();
		$json = $json->encode($data);
		$this->set('json', $json);
	}

	function delete($id) {
		if (!$this->AclAco->delete($id)) {
			$this->failure();
		}
		exit;
	}

	function children($id = null) {
		Configure::write('debug', 0);
		$this->layout = '';

		$node = $this->AclAco->read(null, $id);

		$children = $this->AclAco->children($id, true);

		$sorted = array();
		foreach ($children as $c) {
			$c['AclAco']['children'] = ($c['AclAco']['rght'] - $c['AclAco']['lft'] - 1) / 2;
			$sorted[$c['AclAco']['alias']] = $c;
		}
		ksort($sorted);

		$this->set('node', $node);
		$this->set('children', $sorted);
	}

	function add() {
		if (isset($this->data['AclAco']['parent_id']) &&  !$this->data['AclAco']['parent_id']) {
			$this->data['AclAco']['parent_id'] = null;
		}
		if (!$this->AclAco->save($this->data)) {
			$this->failure();
		}
		exit;
	}

	function update() {
		if (isset($this->data['AclAco']['parent_id']) &&  !$this->data['AclAco']['parent_id']) {
			$this->data['AclAco']['parent_id'] = null;
		}
		$this->layout = '';
		if (!$this->AclAco->save($this->data)) {
			$this->failure();
		}
		exit;
	}

        /**
         * Set values for the view and call for processing of data posted from the view
         *
         * # $lineNames - array of existing tree elements for use in select inputs
         *                with empty element 0 unshifted onto the begining
         * # $names - array of possible names if the tree draws names from a related file
         *            with empty element 0 unshifted onto the begining
         * # $foreign_name - automatically sets to true based on $displayField if you're using
         *                   a related file to hold a pool of element names. This controls
         *                   creation of form components in the view
         * # $displayField - ModelName.fieldName version of $this->Model->displayField
         *
         * @param int $id Id of the record to edit
         */

	function admin_manage_tree($id=null) {

            $period_position = strpos($this->{$this->modelClass}->displayField, '.'); //returns int or FALSE
            if($period_position){
               // the period indicates a foreign name
                $name_model = substr($this->{$this->modelClass}->displayField, 0, $period_position);
                $displayField = $this->{$this->modelClass}->displayField;
                $this->set('foreign_name',TRUE);
            } else {
                $name_model = $this->modelClass;
                $displayField = $this->modelClass . '.' . $this->{$this->modelClass}->displayField;
                $this->set('foreign_name',FALSE);
            }

            $this->set('cr', "\n");

            // get the Nagigator.id/Navline.name list for select inputs
               $listData = $this->{$this->modelClass}->find(
                  'all',
                  array(
                    'fields' => array(
                       "{$this->modelClass}.id",
                       "{$this->modelClass}.lft",
                       "concat({$this->modelClass}.id,' ',{$displayField}) as lineitem"
                    ),
                    'recursive' => 2,
                    'order' => "{$this->modelClass}.lft ASC"
                  )
               );

               // put a blank item on the beginning. This will be our first/default select item
               array_unshift($listData, array(
                   $this->modelClass => array(
                       'id' => 0
                   ),
                   array('lineitem' => '')
               ));
               $lineNames = Set::combine($listData, "{n}.{$this->modelClass}.id", '{n}.0.lineitem');
               $this->set('lineNames', $lineNames);

               // Now make the Name select list
               // ***************************************
               if ($this->viewVars['foreign_name']){
                   $names = $this->{$this->modelClass}->$name_model->find('list');
               $names[0] = '';
               $this->set('names',$names);
               }


                // Get the complete tree, will be displayed for user reference
		$tree = $this->{$this->modelClass}->generatetreelist(
			null,
			"{n}.{$this->modelClass}.id",
			"{n}.$displayField",
			'&nbsp;&nbsp;&nbsp;',
			2
		);

                $this->set('tree', $tree);


                // Load the record if $id is set
		$this->set('id', $id);
                if (!is_null($id)) {
			$this->data = $this->{$this->modelClass}->read(null, $id);
		}
                $this->tree_crud();
                // redirect to get an updated view

	}

	function tree_crud() {
            if (isset($_POST['data'])) {
                switch ($_POST['data']["{$this->modelClass}"]['action']) {
                    case 'e': //New Element
                        if ($_POST['data']['New']['name_id'] != '0'|| $_POST['data']['New']['new_name'] != "") {
                            //$this->Session->setFlash("Time to run the 'new' function");
                            $this->newTreeElement();
                            $this->redirect(array('action' => 'manage_tree'));
                        } else {
                            $this->Session->setFlash("You didn't enter a name or select an existing name");
                        }
                        break;
                    case 'r': //Remane Element
                        if (($_POST['data']['Rename']['name_id'] != '0'|| $_POST['data']['Rename']['new_name'] != "")
                                && $_POST['data']['Rename']['id'] != 0) {
                            $this->Session->setFlash("Time to run the rename function");
                            $this->redirect(array('action' => 'manage_tree'));
                            //$this->renameTreeElement();
                        } else {
                            $this->Session->setFlash("You didn't enter a name in 'New Element' or select an existing element to rename.");
                        }
                        break;
                    case 'd': //Delete Element
                        if ($_POST['data']['Delete']['id'] != '-1') {
                            $this->deleteTreeElement();
                            $this->redirect(array('action' => 'manage_tree'));
                        } else {
                            $this->Session->setFlash("You didn't pick an element to delete.");
                        }
                        break;
                    case 'u': //Move Element Up
                        if ($_POST['data']['id'] != '-1' && $_POST['data']['delta'] != '-1') {
                            $this->moveUPTreeElement();
                        } else {
                            $this->Session->setFlash("No element or move amount was chosen.");
                        }
                        break;
                    case 'w': //Move Element Down
                        if ($_POST['data']['id'] != '-1' && $_POST['data']['delta'] != '-1') {
                            $this->moveDownTreeElement();
                        } else {
                            $this->Session->setFlash("No element or move amount was chosen.");
                        }
                        break;
                    case 'p': //New Parent for Element
                        if ($_POST['data']['parent']['id'] != '-1' && $_POST['data']['parent']['parent_id'] != '-1') {
                            $this->asignParentTreeElement();
                            $this->redirect(array('action' => 'manage_tree'));
                        } else {
                            $this->Session->setFlash("No element or parent was selected.");
                        }
                        break;
                    default :
                        $this->Session->setFlash('No action or unknown action was selected.');
                }
            } else {
                $this->Session->setFlash('No action, the array was not set.');

            }
        }

        function newTreeElement() {
            if ($_POST['data']['New']['new_name'] != "") {
                $newName['Navline']['name'] =  $_POST['data']['New']['new_name'];
                $this->{$this->modelClass}->Navline->save($newName);
                $newName[$this->modelClass]['navline_id'] = $this->Navigator->Navline->id;
            } else {
                $newName[$this->modelClass]['navline_id'] = $_POST['data']['New']['name_id'];
            }

                $newName[$this->modelClass]['parent_id'] = $_POST['data']['New']['parent_id'];
                $newName[$this->modelClass]['account'] = 0;
                $this->{$this->modelClass}->save($newName);
//            $data['Category']['name'] =  $_POST['data']['name'];
//            $this->Category->save($data);
	}

	function renameTreeElement() {
            $this->Category->id = $_POST['data']['id']; // id of Extreme knitting
            $this->Category->save(array('name' => $_POST['data']['name']));
	}

	function deleteTreeElement() {
		$this->{$this->modelClass}->id = $_POST['data']['Delete']['id'];
                //debug($this->Navigator->id);
		$this->{$this->modelClass}->delete();

	}

	function asignParentTreeElement() {
		$this->{$this->modelClass}->id = $_POST['data']['parent']['id'];
		$this->{$this->modelClass}->parent_id = $_POST['data']['parent']['parent_id'];
		$this->{$this->modelClass}->save(array('parent_id'=>$this->{$this->modelClass}->parent_id));
	}


}

?>
