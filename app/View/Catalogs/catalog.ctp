<?php
echo $this->Html->para('', 'It\'s not easy to price truely custom work without some discussion. However, choose from the '.count($tableSet['Catalog']).' product categories below and I\'ll give it a try.');

echo $this->Html->wrapScriptBlock($js);
    
    foreach ($tableSet['Catalog'] as $productCategory => $product) {
        echo $this->Form->create(false, array('id' => 'orderform'.$productCategory, 'url' => array('controller' => 'catalogs', 'action' => 'order')));
        $setList = $setlists[$productCategory];
        $this->set(compact('setList', 'productCategory', 'product'));
        echo $this->element('product_table', array($product, $productCategory, $setList));

        echo $this->element('options_all', array(
            $productCategory,
            'useremail' => (isset($useremail)) ? $useremail : '',
            $leatherOptions,
            $clothOptions,
            $endpaperOptions,
            $diagramMap // tells which products get diagrams. Used for element options_productDiagram
            )
        );
?>
    </form>
<?php
    }
?>
<!--    <table>
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
    </table>-->