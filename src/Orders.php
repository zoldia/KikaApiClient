<?php

namespace Kika\ApiClient;


class Orders
{

	/** @var RestApi */
	private $api;


	public function __construct(RestApi $api)
	{
		$this->api = $api;
	}


	public function create(array $data)
	{
		return $this->api->post('orders', $data);
	}


	public function update($id, array $data)
	{
		return $this->api->put("orders?id=$id", $data);
	}


	public function delete($id)
	{
		return $this->api->delete("orders?id=$id");
	}


	public function anonymization($id)
	{
		return $this->api->put("anonymization?id=$id", ['id' => $id]);
	}


	public function read($id)
	{
		return $this->api->get("orders?id=$id");
	}

}