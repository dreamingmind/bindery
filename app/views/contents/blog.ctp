<?php
//debug($recentTitles);
//debug($most_recent);
?>
<h1><?php echo $html->tag('h1',$most_recent[0]['Content']['heading']); ?></h1>
<?php
$last_update = 0;
foreach($most_recent as $update){
    if ($update['ContentCollection']['content_id']!=$last_update){
        echo $html->tag('p',$update['Content']['content']);
echo $this->Html->image(
        'images'.DS.'thumb'.DS.'x500y375'.DS.$update['Content']['Image']['img_file'],
        array('alt'=>$update['Content']['Image']['alt'].' '.$update['Content']['Image']['alt']))."\n";
        $last_update = $update['ContentCollection']['content_id'];
    }
}
?>