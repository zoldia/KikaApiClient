<?php

namespace Kika\ApiClient;


class Products
{

	/** @var RestApi */
	private $api;


	public function __construct(RestApi $api)
	{
		$this->api = $api;
	}


	public function create(array $data)
	{
		return $this->api->post('product', $data);
	}


	public function update($id, array $data)
	{
		return $this->api->patch("product?id=$id", $data);
	}


	public function read($id)
	{
		return $this->api->get("product?id=$id");
	}


	public function readAll($page=1)
	{
		return $this->api->get("product?page=$page");
	}

}