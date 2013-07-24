<?php
echo $this->Html->div('', NULL, array(
    'id' => 'diagram',
    'class' => $productCategory,
    'setlist' => 'order',
    'option' => 'slave-'.$productCategory));
    echo $this->Html->div($productCategory, NULL, array('id' => 'case'));
        echo $this->Html->div('empty', '', array(
            'id' => 'spine',
            'option' => 'slave-'.$productCategory,
            'setlist' => 'FullLeather QuarterBound'));
        echo $this->Html->div('empty', '', array(
            'id' => 'boards',
            'option' => 'slave-'.$productCategory,
            'setlist' => 'QuarterBound'));
        echo $this->Html->div('empty', '',array(
            'id' => 'belt',
            'option' => 'slave-belt',
            'setlist' => 'Yes'));
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
echo '</div>';
?>