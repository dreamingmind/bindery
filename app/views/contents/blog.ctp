<?php
//debug($recentTitles);
//debug($most_recent);die;
 echo $html->tag('h1',$most_recent[0]['Content']['heading']);
//debug($userdata);

foreach($most_recent as $entry){
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
}
?>