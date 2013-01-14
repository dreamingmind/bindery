<?php
//debug($recentTitles);die;
//debug($most_recent);
$path = 'images/thumb/x160y120/';
?>
<h1>Recent updates</h1>
<ul>
<?php
foreach($recentTitles as $li){
        $img = $html->image($path.$li['Image']['img_file'], array(
            'id'=>'im'.$li['Image']['id'],
            'alt'=>$li['Image']['alt'],
            'title'=>$li['Image']['title']
        ));
        $head = $html->tag('h2',$li['Content']['heading']);
        $txt = $html->para('',TextHelper::truncate($li['Content']['content'],50));
        $link = $html->link('Go', array(
            'controller'=>'contents',
            'pname'=>$li['ContentCollection'][0]['Collection']['slug'],
            'action'=>'newsfeed',
            '/#id'.$li['Content']['id']
        ));
        echo $img . $head . $txt . $link;
}
?>
</ul>
<?php
$last_update = 0;
foreach($most_recent as $update){
    if ($update['ContentCollection']['content_id']!=$last_update){
        echo $html->tag('h1',$update['Collection']['heading']);
        echo $html->tag('h2',$update['Content']['heading']);
        echo $html->tag('p',$update['Content']['content']);
echo $this->Html->image(
        'images'.DS.'thumb'.DS.'x500y375'.DS.$update['Content']['Image']['img_file'],
        array('alt'=>$update['Content']['Image']['alt'].' '.$update['Content']['Image']['alt']))."\n";
        $last_update = $update['ContentCollection']['content_id'];
    }
}
?>