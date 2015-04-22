<?php
/**
 * ally.php
 *
 * ally application model
 *
 * @package		InvisMVC
 * @author		iSolution
 */
 

class Product extends iModel
{	
	function Product()
	{
		$this->iModel();
	}

	function product_input($product)
	{
		$this->set_opt('product');
		$val = array('title'=>$product['title'],'descrp'=>$product['description'],'rprice'=>$product['rprice'],'sprice'=>$product['sprice'],'priceunit'=>$product['price-unit'],'cat'=>$product['category'],'subcat'=>$product['Sub-Category'],'adate'=>time());
		$this->add_row($val);
	}

}

?>