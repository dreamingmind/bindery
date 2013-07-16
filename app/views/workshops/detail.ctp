<?php
//Display the detail workshop
echo $this->element('workshopFeature');

//Open Admin Edit Form
echo $this->element('content_AjaxEdit_record');

//Provide button to edit the feature element
echo $this->element('editContentAjaxButton');

//Display articles related to this workshop
foreach($article as $entry){
    $cls = str_replace(array('.','-'), '', $entry['Content']['Image']['img_file']);
    echo $html->div('entry',

'        <menu class="local_zoom" id="'.$cls.'" >
            <a class="local_scale_tool">-</a> 
            <a class="local_scale_tool">+</a>
        </menu>
'
        // the div content
        . $html->image(
            'images'.DS.'thumb'.DS.'x320y240'.DS.$entry['Content']['Image']['img_file'],
            array('alt'=>$entry['Content']['Image']['alt'].' '.$entry['Content']['Image']['alt'],
                'class'=>'scalable '.$cls)
        )
        ."\n"
        . $html->div($cls . ' entryText x320y240 markdown',Markdown($entry['Content']['content']),
        array(''/* the div attributes */)));
    
//    Provide button to edit article elements
    echo $this->element('editContentAjaxButton');

}
//Close Admin Edit Form
echo $this->element('content_AjaxEdit_closeForm'); //was echo </form>;
?>