<div id="sequence_panel">
    <?php
        foreach($most_recent as $entry){
        echo $html->image(
            'images'.DS.'thumb'.DS.'x160y120'.DS.$entry['Content']['Image']['img_file'],
            array('alt'=>$entry['Content']['Image']['alt'].' '.$entry['Content']['Image']['alt'],
                'class'=>'scalable')
        ) . '</ br>';
        }
    ?>
</div>