<?php
/**
 * TOP API: alibaba.wholesale.category.get request
 * 
 * @author auto create
 * @since 1.0, 2015.04.23
 */
class AlibabaWholesaleCategoryGetRequest
{
	
	private $apiParas = array();
	
	public function getApiMethodName()
	{
		return "alibaba.wholesale.category.get";
	}
	
	public function getApiParas()
	{
		return $this->apiParas;
	}
	
	public function check()
	{
		
	}
	
	public function putOtherTextParam($key, $value) {
		$this->apiParas[$key] = $value;
		$this->$key = $value;
	}
}
