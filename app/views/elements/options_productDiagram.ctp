<?php
echo $this->Html->div($productCategory, NULL, array('id' => 'case'));
    echo $this->Html->div('empty', '', array('id' => 'spine'));
    echo $this->Html->div('empty', '', array('id' => 'boards'));
    echo $this->Html->div('belt', '');
echo '</div>';
echo $this->Html->div($productCategory, NULL, array('id' => 'liner'));
    echo $this->Html->div('empty', '', array('id' => 'front'));
    echo $this->Html->div('empty', '', array('id' => 'frontPocket'));
    echo $this->Html->div('empty', '', array('id' => 'back'));
    echo $this->Html->div('empty', '', array('id' => 'backPocket'));
echo '</div>';
echo $this->Html->div($productCategory, NULL, array('id' => 'page'));
    echo $this->Html->div('endpaper', '');
    echo $this->Html->div('paper', '');
echo '</div>';
?>