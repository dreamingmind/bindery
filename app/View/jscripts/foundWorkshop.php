<?php
//    function foundWorkshopBlock($exhibit, $path = 'images/thumb/x160y120/'){
////        if ($exhibit['ContentCollection']['content_id']!=$last_update){
//
//        $patterns = array('/[\[|!\[]/','/\]\([\s|\S]+\)/','/\s[\s]+/','/#/');
//        $replace = array('','',' ','');
//            
//            //remove links and image links from markdown content
//            $clean = preg_replace($patterns, $replace,$exhibit['ContentCollection']['0']['Content']['content']);
//            $collection = $this->Html->para('aside','ID: '.$exhibit['ContentCollection']['0']['Content']['id'].' - '.$exhibit['Workshop']['heading']);
//            //make the heading into the <A> tag
//            //and follow it with truncated markdown content
//            $link_uri = DS.'products'.DS.$exhibit['Workshop']['slug'].DS.'gallery'.DS.'id:'.$exhibit['Workshop']['id'];
//            $heading_link = $this->Html->link($this->Html->truncateText($exhibit['Workshop']['heading'],45),$link_uri) 
//                    . markdown($this->Html->truncateText($clean,100,array('force'=>true)));
//            //assemble the image link
//            $img = $this->Html->image($path.$exhibit['ContentCollection']['0']['Content']['Image']['img_file'], array(
//    //            'id'=>'im'.$exhibit['Workshop']['Image']['id'],
//                'alt'=>$exhibit['ContentCollection']['0']['Content']['Image']['alt'],
//                'title'=>$exhibit['ContentCollection']['0']['Content']['Image']['title']
//            ));
//            $image_link = $this->Html->link($img,$link_uri,array('escape'=>false));
//
//        echo $this->Html->div('linkDiv', $image_link . $collection . $heading_link);
//    }
?>
