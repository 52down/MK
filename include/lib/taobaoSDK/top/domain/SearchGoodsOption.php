<?php

/**
 * Alibaba ICBU 在线批发产品搜索参数
 * @author auto create
 */
class SearchGoodsOption
{
	
	/** 
	 * category_id 搜索类目
	 **/
	public $categoryId;
	
	/** 
	 * keyword 搜索关键词
	 **/
	public $keyword;
	
	/** 
	 * min_order_from 最小起订量区间
	 **/
	public $minOrderFrom;
	
	/** 
	 * min_order_to 最小起订量区间
	 **/
	public $minOrderTo;
	
	/** 
	 * page_no 当前页面
	 **/
	public $pageNo;
	
	/** 
	 * page_size 每页大小
	 **/
	public $pageSize;
	
	/** 
	 * price_from_cent 最小价格
	 **/
	public $priceFromCent;
	
	/** 
	 * price_to_cent 最大价格
	 **/
	public $priceToCent;
	
	/** 
	 * sort_by 排序方式
	 **/
	public $sortBy;	
}
?>