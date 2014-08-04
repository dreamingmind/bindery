<?php
if ($diagramMap[$productCategory]) {
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
            echo $this->Html->div($productCategory, '', array(
                'id' => 'boards',
                'option' => 'slave-'.$productCategory,
                'setlist' => 'QuarterBound',
                'material' => 'cloth board'));
            // belt and beltloop show the closing belt components
            echo $this->Html->div($productCategory, '',array(
                'id' => 'belt',
                'option' => "slave-belt$productCategory",
                'setlist' => 'Yes',
                'material' => 'leather'));
            echo $this->Html->div($productCategory, '',array(
                'id' => 'beltloop',
                'option' => "slave-belt$productCategory",
                'setlist' => 'Yes',
                'material' => 'leather'));
        echo '</div>';

        // The liner shows cloth liners
        if ($productCategory != 'Journal') {
            echo $this->Html->div($productCategory, NULL, array(
                'id' => 'liner',
                'material' => 'cloth liners',
                'tile' => 'Interior liners\rtypically match the cover cloth\rin in a quarterbound design.'));
                echo $this->Html->div($productCategory, '',array(
                    'id' => 'penloop',
                    'option' => "slave-penloop$productCategory",
                    'setlist' => 'Yes',
                    'material' => 'leather'));
            echo '</div>';
        }
        echo $this->Html->div($productCategory, NULL, array(
            'id' => 'endpaper',
            'option' => 'slave-'.$productCategory,
            'setlist' => 'endpaper',
            'material' => 'endpaper'));
        echo '</div>';
    //    echo $this->Html->div($productCategory, NULL, array(
    //        'id' => 'page',
    //        'option' => 'slave-'.$productCategory,
    //        'setlist' => 'BlankPages RuledPages',
    //        'material' => 'paper'));
    //    echo '</div>';
    echo '</div>';
}
?>