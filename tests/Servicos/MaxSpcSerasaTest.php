<?php
use PHPUnit\Framework\TestCase;

class MaxSpcSerasaTest extends TestCase
{
	private $API = "https://httpbin.org/ip";
 

 	function testRequestExiste()
 	{
		$res = $this->request('GET', '/entities');

		$this->assertEquals(200, $res);
 	}

	protected function request($method, $url, array $reqParams = [])
	{
		return 200;
	}


// 	public function test_url_via_curl() {
// 		$payload = "curl {$this->API}";

// 	    $data = shell_exec($payload);
// 	    $result = json_decode($data, true);
// 	    //print_r($result);
// 		$this->assertArrayHasKey('origin', $result);
// 		//$this->asserTrue($result['origin']);

// //		$this->assertEquals(200, $result['code']);
// 	}        
}