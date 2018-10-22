<?php

namespace Kika\ApiClient;


class RestApi
{

	const S200_OK = 200;
	const S201_CREATED = 201;
	const S204_NO_CONTENT = 204;
	const S400_BAD_REQUEST = 400;

	const GET = 'GET';
	const POST = 'POST';
	const PUT = 'PUT';
	const PATCH = 'PATCH';
	const DELETE = 'DELETE';

	/** @var string */
	private $endpoint = 'https://system.fhb.sk/api/v2';

	/** @var string */
	private $appId;

	/** @var string */
	private $secret;

	/** @var string */
	private $token;

	/** @var \stdClass */
	private $lastResult;


	public function __construct($appId, $secret)
	{
		$this->appId = $appId;
		$this->secret = $secret;
	}


	public function setEndpoint($endpoint)
	{
		$this->endpoint = $endpoint;
	}


	public function getEndpoint()
	{
		return $this->endpoint;
	}


	public function setToken($token)
	{
		$this->token = $token;
	}


	public function getToken()
	{
		if (!$this->token) {
			$this->token = $this->createToken();
		}

		return $this->token;
	}


	public function getLastResult()
	{
		return $this->lastResult;
	}


	public function get($action)
	{
		$result = $this->call(self::GET, $action);
		return $result->json;
	}


	public function post($action, array $data, $code = self::S201_CREATED)
	{
		$result = $this->call(self::POST, $action, $data, $code);
		return $result->json;
	}


	public function put($action, array $data, $code = self::S200_OK)
	{
		$result = $this->call(self::PUT, $action, $data, $code);
		return $result->json;
	}


	public function patch($action, array $data, $code = self::S201_CREATED)
	{
		$result = $this->call(self::PATCH, $action, $data, $code);
		return $result->json;
	}


	public function delete($action)
	{
		$result = $this->call(self::DELETE, $action, [], self::S204_NO_CONTENT);
		return $result->json;
	}


    /**
     * @return \stdClass
     * @throws BadRequestException
     * @throws RestApiException
     */
	public function call($method, $action, array $data = [], $code = self::S200_OK)
	{
		$curl = $this->login($action);
		curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);

		if ($data) {
			curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
		}

		$response = curl_exec($curl);
		$httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
		curl_close($curl);
		$json = json_decode($response);

		if ($httpCode === self::S400_BAD_REQUEST) {
		    throw BadRequestException::fromResponse(json_decode($response, true));
        }

		if ($httpCode !== $code) {
			$message = isset($json->message) ? $json->message : "Unknown error. Http code {$httpCode}.";
			throw new RestApiException($message, $httpCode);
		}

		$this->lastResult = (object) array('httpCode' => $httpCode, 'json' => $json, 'raw' => $response);

		return $this->lastResult;
	}
	

	private function login($action)
	{
		$curl = $this->createCurl($action);

		curl_setopt($curl, CURLOPT_HTTPHEADER, array(
			"Content-Type: application/json",
			"X-Authentication-Simple: " . base64_encode($this->getToken())
		));

		return $curl;
	}


    /**
     * @return string
     * @throws BadRequestException
     * @throws RestApiException
     */
	private function createToken()
	{
		$data = [
			'app_id' => $this->appId,
			'secret' => $this->secret
		];

		$curl = $this->createCurl('login');
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
		curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
		$response = curl_exec($curl);
		$httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

		$json = json_decode($response, true);
		curl_close($curl);

		if ($httpCode === self::S400_BAD_REQUEST) {
		    throw BadRequestException::fromResponse($json);
        }

		if ($httpCode != self::S200_OK) {
			$message = isset($json['message']) ? $json['message'] : "Unknown error. Http code $httpCode.";
			throw new RestApiException($message, $httpCode);
		}

		return $json['token'];
	}


	private function createCurl($action)
	{
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, "{$this->endpoint}/{$action}");
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($curl, CURLOPT_HEADER, FALSE);
		return $curl;
	}

}


class RestApiException extends \Exception
{
}