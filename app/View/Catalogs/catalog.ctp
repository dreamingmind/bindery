<?php
echo $this->Html->para('', 'It\'s not easy to price truely custom work without some discussion. However, choose from the '.count($tableSet['Catalog']).' product categories below and I\'ll give it a try.');

echo $this->Html->wrapScriptBlock($js);
    
// ===================================================
// This will output the elaborate grid purchase systems if they exist
// ===================================================
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
	// ==================================================
	// this will output the simpler project description form if no 
	// product-grid selector is available
	// ==================================================
	if (empty($tableSet['Catalog'])) {
		echo $this->element('describe_project');
	}
