<div id="detail">
    <form action=" " method="post" enctype="multipart/form-data" name="orderform" id="orderform">
        <?php
        foreach ($tableSet['Catalog'] as $productCategory => $products) {
            $setList = $setlists[$productCategory];
            $this->set('setList', $setList);
            $this->set('productCategory', $productCategory);
            $this->set('product', $products);
            echo $this->element('product_table', array($products, $productCategory, $setList), TRUE);
        ?>
            <div class="<?php echo $productCategory.'Toggle'; ?>">
                <?php
                // This should be a call to a method that understands
                // which options belong to which product categories
                    echo $this->element('options_ruling',array('fieldsetOptions'=>array(
                        'option' => 'slave-'.$productCategory, 'setlist' => 'RuledPages'
                    )));
//                    echo $this->element('options_leather',array($leatherOptions));
                    echo $this->element('options_quarterbound',array($leatherOptions, $clothOptions, $endpaperOptions, 'fieldsetOptions'=>array(
                        'option' => 'slave-'.$productCategory, 'setlist' => 'FullLeather QuarterBound'
                    )));
                    echo $this->element('options_closingBelt',array('fieldsetOptions'=>array(
                        'option' => 'slave-'.$productCategory, 'setlist' => 'belt'
                    )));
                    echo $this->element('options_titling',array('fieldsetOptions'=>array(
                        'option' => 'slave-'.$productCategory, 'setlist' => 'titling'
                    )));
                    echo $this->element('options_instructions',array('fieldsetOptions'=>array(
                        'option' => 'slave-'.$productCategory, 'setlist' => 'instructions'
                    )));
                ?>
            </div>
        <?php
        }
//debug($product);
//debug($tableSet);
        echo $this->element('select', array('leather', 'cloth', 'imitation'), true);
        ?>
        <table>
                <td height="47" class="table_heading"></td>
                <td colspan="2" valign="top" class="option_pop"></td>
            </tr>
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
            <tr>
                <td colspan="5" class="option_head"><div align="center" class="table_heading"> <a name="options"></a>Options for all journals </div></td>
            </tr>
            <tr class="option_pop">
                <td class="option_pop"><div align="right"></div>
                    <p align="right"><br>
                    </p></td>
                <td colspan="2" class="option_pop"><p align="right">Closing Belt ($14) Yes

                        <textarea name="instructions" cols="30" rows="5" wrap="VIRTUAL" id="instructions"></textarea>
                    </p>
                    <p align="right">&nbsp; </p></td>
                <td colspan="2" valign="top" class="option_pop"><div align="right">
                        <p>Titling ($9/line) Yes
                            <input   name="title" type="radio" class="option_pop" value="9">
                            No
                            <input   CHECKED name="title" type="radio" class="option_pop" value="0">
                            Lines
                            <select name="lines" size="1" id="lines">
                                <
                                <option value="1" >1</option>
                                <option value="2" >2</option>
                                <option value="3" >3</option>
                                <option value="4" >4</option>
                                <option value="5" >5</option>
                                <option value="6" >6</option>
                                <option value="7" >7</option>
                            </select>
                        </p>
                        <p><span class="style2">Use the following option only if you selected 'Titling Yes' above</span> <br>
                            Titling style
                            <select name="foil" size="1" id="foil">
                                <
                                <option value="" SELECTED>Select foil color</option>
                                <option value="blind" >Blind</option>
                                <option value="black" >Black</option>
                                <option value="gold" >Gold</option>
                                <option value="silver" >Silver</option>
                            </select>
                            <br>
                            <br>
                            The cover should read: <br>
                            <textarea name="title_text" cols="30" rows="2" wrap="VIRTUAL" id="title_text"></textarea>
                            <br>
                        </p>
                    </div></td>
            </tr>
            <tr align="right">
                <td colspan="5" nowrap class="table_bottom
                    ">&nbsp;</td>
            </tr>
        </table>
    </form>
    <p>&nbsp;</p>
</div>
