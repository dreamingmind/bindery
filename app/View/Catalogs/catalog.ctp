<?php
/**
 * Render forms for Custom and Generic product ordering and cart item editing
 * 
 * When we're in EDITING mode, a new View Class is swapped in. This class overrides 
 * the element() method. In this way I can modify the rendering of all the elements 
 * on the page, populating them with the user's pre-existing data and doing other 
 * tasks as appropriate.
 */
echo $this->Html->para('', 'It\'s not easy to price truely custom work without some discussion. However, choose from the '.count($tableSet['Catalog']).' product categories below and I\'ll give it a try.');

echo $this->Html->wrapScriptBlock($js);
//dmDebug::ddd($cartProduct, 'cartProduct');
// ===================================================
// This will output the elaborate grid purchase systems if they exist
// ===================================================
    foreach ($tableSet['Catalog'] as $productCategory => $product) {
//		dmDebug::ddd($productCategory, 'productCategory');
		if (is_a($this, 'CartEditView') && $productCategory != $cartProduct) {
			continue;
		}
        echo $this->Form->create(false, array('id' => 'orderform'.$productCategory, 'url' => array('controller' => 'catalogs', 'action' => 'order')));
		
		// radio buttons in the product grids were not reliably sending thier data in 
		// with the other form data. So, the radio click now sets the 'code' node 
		// and we move the value to it's proper home when the form is submitted. HACK.
		// The move is done in CustomProduct utitlity construct()
		echo $this->Form->input("$productCategory.code", array('type'=>'hidden'));
		
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
	// ==================================================
	// this will output the simpler project description form if no 
	// product-grid selector is available
	// ==================================================
	if (empty($tableSet['Catalog'])) {
		echo $this->element('describe_project');
	}
