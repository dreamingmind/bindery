<?php
/**
 * Self-contained product option div
 * 
 * The option sets are controlled by an external Master element
 * who's setlist attribute will reveal the appropriate groups.
 * 
 * The setlist values common to every product in a productCategory
 * can be looked up in Catalog Model. Products within the group
 * will have additional setlist values. They're in the catalogs table
 * as yyindex, yindex, xxindex, and xindex values for each specific product
 * 
 * The catalogController's catalog action puts together a page that makes
 * all this work.
 * 
 * app.js does the master/slave reveals.
 * catalog.js manages ajax submission of this data.
 * Catalog.js also extends the master/slave filtering
 * and only submits the visible elements, the valid options
 * for this specific product.
 * 
 * <form>
 *      master: an input carrying the product number
 *          Clicking this passes setlist values to this Element
 *          This input also gets submited with the Element inputs
 *      This Element
 * </form>
 */
    echo $this->Html->div($productCategory . 'Toggle options', null);
    echo $this->Html->caveatDiv($productCategory, $caveat['materials']);
    $model = $productCategory;
	dmDebug::ddd($product_group, 'product_group');
	echo $this->Form->input('edit_path', array('type' => 'hidden', 'value' => $product_group));
	
	echo $this->element('Cart/add_to_cart');
//	echo $this->Form->button('Add to cart', array('class' => 'orderButton', 'option' => 'slave-' . $productCategory, 'setlist' => 'order'));
	
    echo $this->Html->para('optionTitle','',array(
            'option' => 'slave-' . $productCategory, 'setlist' => 'order'
        ));
//    echo $this->Html->para('caveat super', '<strong>*</strong> All colors and proportions are approximations.',array(
//            'option' => 'slave-' . $productCategory, 'setlist' => 'order'
//        ));

    echo $this->Form->input($productCategory.'.description', array(
        'class' => 'forcedData',
        'type' => 'hidden',
        'value' => 'empty'
    ));
    // This should be a call to a method that understands
    // which options belong to which product categories
    echo $this->element('options_productDiagram', array($productCategory, $diagramMap));
    echo $this->Html->div($productCategory.'message',''); // this is the ajax'd shopping cart action message
	
	echo $this->Form->input('specs_key', array('type' => 'hidden', 'value' => $productCategory));
	echo $this->Form->input("$productCategory.sum", array('type' => 'hidden', 'value' => 0));
	echo $this->Form->input("$productCategory.total", array('type' => 'hidden', 'value' => 0));
	
    if (isset($usergroupid) && $usergroupid < 3){
//        echo $this->element('product_name', array('fieldsetOptions' => array(
//            'option' => 'slave-' . $productCategory, 'setlist' => 'order'),'model' => $model,'record' => array($model => array('email' => $useremail))));
    }
    echo $this->element('email', array('fieldsetOptions' => array(
        'option' => 'slave-' . $productCategory, 'setlist' => 'order'),'model' => $model,'record' => array($model => array('email' => $useremail))));
    echo $this->Cart->cartItemIdInput(); // concrete helpers decide
    echo $this->element('options_quantity', array('fieldsetOptions' => array(
        'option' => 'slave-' . $productCategory, 'setlist' => 'order'),'model' => $model,'record' => array($model => array('quantity' => 1))));//
    echo $this->element('options_quarterbound', array($leatherOptions, $clothOptions, $endpaperOptions, 'fieldsetOptions' => array(
        'option' => 'slave-' . $productCategory, 'setlist' => 'FullLeather QuarterBound'),'model' => $model));
    echo $this->element('options_closingBelt', array('fieldsetOptions' => array(
        'option' => 'slave-' . $productCategory, 'setlist' => 'belt'),'model' => $model));
    echo $this->element('options_endpaper', array($endpaperOptions, 'fieldsetOptions' => array(
        'option' => 'slave-' . $productCategory, 'setlist' => 'endpaper'),'model' => $model));
    echo $this->element('options_ruling', array('fieldsetOptions' => array(
        'option' => 'slave-' . $productCategory, 'setlist' => 'RuledPages'),'model' => $model));
    echo $this->element('options_page_count', array('fieldsetOptions' => array(
        'option' => 'slave-' . $productCategory, 'setlist' => 'pagecount'),'model' => $model));
    echo $this->element('options_penLoop', array('fieldsetOptions' => array(
        'option' => 'slave-' . $productCategory, 'setlist' => 'penloop'),'model' => $model));
    echo $this->element('options_titling', array('fieldsetOptions' => array(
        'option' => 'slave-' . $productCategory, 'setlist' => 'titling'),'model' => $model));
    echo $this->element('options_instructions', array('fieldsetOptions' => array(
        'option' => 'slave-' . $productCategory, 'setlist' => 'instructions'),'model' => $model));
    echo $this->element('options_reusable', array('fieldsetOptions' => array(
        'option' => 'slave-' . $productCategory, 'setlist' => 'bookbody'),'model' => $model));
?>
</div>