<?php
echo $this->Html->div('', NULL, array(
    'id' => 'diagram',
    'class' => $productCategory,
    'setlist' => 'order',
    'option' => 'slave-'.$productCategory));

    // The case layer shows leather for full leather or quarterbound
    echo $this->Html->div($productCategory, NULL, array(
        'id' => 'case',
        'option' => 'slave-'.$productCategory,
        'setlist' => 'FullLeather QuarterBound',
        'material' => 'leather'
        ));
        // the boards layer shows the cloth portion of a quarterbound case
        echo $this->Html->div('empty', '', array(
            'id' => 'boards',
            'option' => 'slave-'.$productCategory,
            'setlist' => 'QuarterBound',
            'material' => 'cloth'));
        // belt and beltloop show the closing belt components
        echo $this->Html->div('empty', '',array(
            'id' => 'belt',
            'option' => 'slave-belt',
            'setlist' => 'Yes',
            'material' => 'leather'));
        echo $this->Html->div('empty', '',array(
            'id' => 'beltloop',
            'option' => 'slave-belt',
            'setlist' => 'Yes',
            'material' => 'leather'));
    echo '</div>';
    
    // The liner shows cloth liners
    echo $this->Html->div($productCategory, NULL, array('id' => 'liner'));
        echo $this->Html->div('empty', '', array('id' => 'front'));
        echo $this->Html->div('empty', '', array('id' => 'frontPocket'));
        echo $this->Html->div('empty', '', array('id' => 'back'));
        echo $this->Html->div('empty', '', array('id' => 'backPocket'));
    echo '</div>';
    echo $this->Html->div($productCategory, NULL, array(
        'id' => 'endpaper',
        'option' => 'slave-'.$productCategory,
        'setlist' => 'endpapers',
        'material' => 'endpaper'));
    echo '</div>';
//    echo $this->Html->div($productCategory, NULL, array(
//        'id' => 'page',
//        'option' => 'slave-'.$productCategory,
//        'setlist' => 'BlankPages RuledPages',
//        'material' => 'paper'));
//    echo '</div>';
echo '</div>';
?>