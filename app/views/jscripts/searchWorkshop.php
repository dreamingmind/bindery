<?php
    function siteSearchWorkshopBlock(&$view, $exhibit, $path = 'images/thumb/x160y120/'){
//        if ($exhibit['ContentCollection']['content_id']!=$last_update){

        $patterns = array('/[\[|!\[]/','/\]\([\s|\S]+\)/','/\s[\s]+/','/#/');
        $replace = array('','',' ','');
            
            //remove links and image links from markdown content
            $clean = preg_replace($patterns, $replace,$exhibit['Content']['content']);
            $collection = $this->Html->para('aside','ID: '.$exhibit['Content']['id'].' - '.$exhibit['Content']['heading']);
            //make the heading into the <A> tag
            //and follow it with truncated markdown content
            $link_uri = DS.'products'.DS.$exhibit['Content']['slug'].DS.'gallery'.DS.'id:'.$exhibit['Content']['id'];
            $heading_link = $this->Html->link($this->Html->truncateText($exhibit['Content']['heading'],45),$link_uri) 
                    . markdown($this->Html->truncateText($clean,100,array('force'=>true)));
            //assemble the image link
            $img = $this->Html->image($path.$exhibit['Image']['img_file'], array(
    //            'id'=>'im'.$exhibit['Workshop']['Image']['id'],
                'alt'=>$exhibit['Image']['alt'],
                'title'=>$exhibit['Image']['title']
            ));
            $image_link = $this->Html->link($img,$link_uri,array('escape'=>false));
            $resetDateLinks = $this->assembleDateResetLinks($view, $exhibit);

        echo $this->Html->div('linkDiv', $image_link . $collection . $heading_link . $resetDateLinks);
    }
?>
