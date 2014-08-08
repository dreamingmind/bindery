<?php

//debug($article);
//debug($feature);
//Provide head tag to sead javascript elements for editing
echo $this->Html->tag('h1', $feature['ContentCollection'][0]['Collection']['heading'], array(
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

//Display articles related to this workshop
foreach ($article as $index => $entry) {
    $cls = str_replace(array('.', '-'), '', $entry['Content']['Image']['img_file']);
    echo $this->Html->div('entry', '        <menu class="local_zoom" id="' . $cls . '" >
            <a class="local_scale_tool">-</a> 
            <a class="local_scale_tool">+</a>
        </menu>
'
            // the div content
            . $this->Html->image(
                    'images' . DS . 'thumb' . DS . 'x320y240' . DS . $entry['Content']['Image']['img_file'], array('alt' => $entry['Content']['Image']['alt'] . ' ' . $entry['Content']['Image']['alt'],
                'class' => 'scalable ' . $cls)
            )
            . "\n"
            . $this->Html->div($cls . ' entryText x320y240 markdown', $this->Markdown->transform($entry['Content']['content']), array(''/* the div attributes */)));

    //Display the content collection edit button
//    debug($entry);
    echo $this->Html->changeCollection($this->viewVars, $entry['Content']['slug'], $entry['Workshop']['id']);

    //    Provide button to edit article elements - array elements stolen from artExhibit 51-54
    echo $this->element('content_AjaxEdit_editRequestButton', array(
        'slug' => $article[$index]['Content']['slug'],
        'id' => $article[$index]['Content']['id']
    ));
}
//Close Admin Edit Form
echo $this->element('content_AjaxEdit_closeForm'); //was echo </form>;
?>