<?php
echo $this->Form->create(false, array('id' => 'orderform', 'url' => array('controller' => 'catalogs', 'action' => 'catalog')));
//<form action=" " method="post" enctype="multipart/form-data" name="orderform" id="orderform">
    foreach ($tableSet['Catalog'] as $productCategory => $products) {
        $setList = $setlists[$productCategory];
        $this->set('setList', $setList);
        $this->set('productCategory', $productCategory);
        $this->set('product', $products);
        echo $this->element('product_table', array($products, $productCategory, $setList), TRUE);
        ?>
        <div class="<?php echo $productCategory . 'Toggle options'; ?>">
            <?php
            $model = $productCategory;
            // This should be a call to a method that understands
            // which options belong to which product categories
            echo $this->Form->button('Order', array('option' => 'slave-' . $productCategory, 'setlist' => 'order'));
            echo $this->element('options_ruling', array('fieldsetOptions' => array(
                    'option' => 'slave-' . $productCategory, 'setlist' => 'RuledPages'
                ),
                'model' => $model));
//                    echo $this->element('options_leather',array($leatherOptions));
            echo $this->element('options_quarterbound', array($leatherOptions, $clothOptions, $endpaperOptions, 'fieldsetOptions' => array(
                    'option' => 'slave-' . $productCategory, 'setlist' => 'FullLeather QuarterBound'
                ),
                'model' => $model));
            echo $this->element('options_closingBelt', array('fieldsetOptions' => array(
                    'option' => 'slave-' . $productCategory, 'setlist' => 'belt'
                ),
                'model' => $model));
            echo $this->element('options_titling', array('fieldsetOptions' => array(
                    'option' => 'slave-' . $productCategory, 'setlist' => 'titling'
                ),
                'model' => $model));
            echo $this->element('options_instructions', array('fieldsetOptions' => array(
                    'option' => 'slave-' . $productCategory, 'setlist' => 'instructions'
                ),
                'model' => $model));
            echo $this->element('options_reusable', array('fieldsetOptions' => array(
                    'option' => 'slave-' . $productCategory, 'setlist' => 'bookbody'
                ),
                'model' => $model));
            ?>
        </div>
        <?php
    }
//debug($product);
//debug($tableSet);
    ?>
    <table>
        <tr>
            <td colspan="5" valign="top" class="table_name"><div align="right"> <span class="style4"></span>
                    <a href=""> <img src="../gal_nav_images/reset.jpg" name="Reset" border="0" ></a> <span class="style5">
                    </span>
                    <input type="image" src="../gal_nav_images/update.jpg" name="reset" value="update" onClick="document.orderform.action='';document.orderform.submit();">
                    Courtesy Quote: $0    <span class="style5">..</span> <span class="style5"> </span>
                    <input type="image" src="../gal_nav_images/cart.jpg" name="addtocart" value="addtocart" onClick="document.orderform.action='pp_stepstone.php';document.orderform.submit();">
                    <br>
                    <span class="style5"></span> <span class="style5">
                        <input type="hidden" name="cmd" value="_cart">
                        <input type="hidden" name="business" value="ddrake@dreamingmind.com">
                        <input type="hidden" name="display" value="1">
                        <input type="image" img src="../gal_nav_images/checkout.jpg" name="seecart" value="seecart" onClick="document.orderform.action='https://www.paypal.com/cgi-bin/webscr';document.orderform.target='Paypal';document.orderform.submit();">
                    </span><br>
                    <span class="style4">Quote price is an estimate and does not include shipping or sales tax (for CA residents)</span> </div></td>
        </tr>
    </table>
<?php echo $this->Form->end('Submit'); ?>