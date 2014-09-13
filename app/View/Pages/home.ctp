<div>
    <?php
    echo $this->Html->div('linkDiv', ' ');
    echo $this->Html->foundNewBlock($this->viewVars, $recentNews[0],'images/thumb/x160y120/');
    echo $this->Html->foundGalleryBlock($this->viewVars, $recentExhibits[0],'images/thumb/x160y120/');
?>
</div>
<div id="personshot" class="clear">
    <?php
    echo $this->Html->para(null,$record[0]['Content']['content']);
    echo $this->Html->image('images/thumb/x640y480/'. $record[0]['Image']['img_file']);
//    debug($recentNews);
    ?>
</div>
