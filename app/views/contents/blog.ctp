<?php
//debug($recentTitles);
//debug($most_recent);die;
?>
<h1><?php echo $html->tag('h1',$most_recent[0]['Content']['heading']); ?></h1>
<?php
$divimg = '<div id="di">';
$divp = '<div id="dp">';
foreach($most_recent as $update){
    $divimg .= $this->Html->image(
        'images'.DS.'thumb'.DS.'x320y240'.DS.$update['Content']['Image']['img_file'],
        array('alt'=>$update['Content']['Image']['alt'].' '.$update['Content']['Image']['alt']))."\n";
        $last_update = $update['ContentCollection']['content_id'];
    $divp .= Markdown($update['Content']['content']);
}
$divimg .= "</div>";
$divp .= '</div>';
echo $divimg;
echo $divp;
?>