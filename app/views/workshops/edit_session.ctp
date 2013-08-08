<?php

//debug($article);
//debug($feature);
//Provide head tag to sead javascript elements for editing
echo $html->tag('h1', $feature['ContentCollection'][0]['Collection']['heading'], array(
    'class' => 'related',
    'collection' => $feature['ContentCollection'][0]['Collection']['id']
));

//Display the detail workshop
echo $this->element('workshopFeature');

//Display content collection edit button
echo $this->Html->changeCollection($this->viewVars, $feature['ContentCollection'][0]['Content']['slug'], $feature['ContentCollection'][0]['Collection']['id']);

//Open Admin Edit Form
echo $this->element('content_AjaxEdit_openForm');

//Provide button to edit the feature element - array elements stolen from artExhibit 51-54
echo $this->element('content_AjaxEdit_editRequestButton', array(
    'slug' => $feature['ContentCollection'][0]['Content']['slug'],
    'id' => $feature['ContentCollection'][0]['Content']['id']
));

//Close Admin Edit Form
echo $this->element('content_AjaxEdit_closeForm'); //was echo </form>;

//Open Session Edit Form
echo $this->Form->create('Workshop');
echo $this->element('workshopForm_metaFields');
echo $this->element('workshopForm_dataFields');
// for each Session as $sess echo $this->element('workshopForm_sessionFields);
// Insert add button
echo $this->Form->end('Submit');
//Show Exisiting sessions

//



?>