<?php /* @var $this ViewCC */ ?> 
<?php
//<p>
//debug($record);
//debug($neighbors);
//debug($filmStrip);
////debug($introduction);
//debug($exhibit);
//debug($this->params);
//debug($nextPage);
//debug($previousPage);
//debug($this->Paginator->params);</p>
?>
<?php
echo $this->Html->image(
        'images'.DS.'thumb'.DS.'x640y480'.DS.$record['Image']['img_file'],
        array('alt'=>$record['Image']['alt'].' '.$record['Content']['alt']))."\n";
//<img alt="" src="/bindery/img/images/thumb/x640y480/DSCN3920.jpg">
?>
<style media="screen" type="text/css">
    <!--
    #detail {
        position: relative;
    }
    #proseblock {
        position: absolute;
        z-index: 3;
        top: <?php echo $record['Image']['Supplement']['top_val'] ?>px;
        left: <?php echo $record['Image']['Supplement']['left_val'] ?>px;
        width: <?php echo $record['Image']['Supplement']['width_val'] ?>px;
        height: <?php echo $record['Image']['Supplement']['height_val'] ?>px;
    }
    -->
</style>
<div id="proseblock">
<span class="<?php echo $record['Image']['Supplement']['headstyle'] ?>"><?php echo $record['Content']['heading'] ?></span>
<br>
<br>
<span class="<?php echo $record['Image']['Supplement']['pgraphstyle'] ?>"><?php echo Markdown($record['Content']['content']) ?><br><br><br><br></span>
</div>