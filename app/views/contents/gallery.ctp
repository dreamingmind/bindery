<?php /* @var $this ViewCC */ ?> 
<?php
//<p>
//debug($record);die;
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
        top: <?php echo $record['ContentCollection'][0]['top_val'] ?>px;
        left: <?php echo $record['ContentCollection'][0]['left_val'] ?>px;
        width: <?php echo $record['ContentCollection'][0]['width_val'] ?>px;
        height: <?php echo $record['ContentCollection'][0]['height_val'] ?>px;
    }
    -->
</style>
<div id="proseblock">
<span class="<?php echo $record['ContentCollection'][0]['headstyle'] ?>"><?php echo $record['Content']['heading'] ?></span>
<br>
<br>
<div class="markdown <?php echo $record['ContentCollection'][0]['pgraphstyle'] ?>"><?php echo Markdown($record['Content']['content']) ?><br><br><br><br></div>
</div>