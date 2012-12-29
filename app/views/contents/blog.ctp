<?php
//debug($recentTitles);
//debug($most_recent);die;
 echo $html->tag('h1',$most_recent[0]['Content']['heading']);


foreach($most_recent as $entry){
    echo $html->div('entry',
        // the div content
        $html->image(
            'images'.DS.'thumb'.DS.'x640y480'.DS.$entry['Content']['Image']['img_file'],
            array('alt'=>$entry['Content']['Image']['alt'].' '.$entry['Content']['Image']['alt'])
        )
        ."<menu class='zoom'><a>-</a> <a>+</a></menu>"
        ."\n"
        . $html->div('entryText',Markdown($entry['Content']['content']),
        array(''/* the div attributes */)));
}
?>