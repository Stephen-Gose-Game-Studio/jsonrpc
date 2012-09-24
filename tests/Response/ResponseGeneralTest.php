<?php

use \JsonRpc\Base\Rpc;

class ResponseGeneralTest extends Response\Base
{

  public function testValidResponseResult()
  {
    $data = '{"jsonrpc": "2.0", "result": 6, "id": 1}';
    $expects = '';
    $fault = $this->getResponseFault($data);
    $this->assertEquals($expects, $fault);
  }

  public function testValidResponseError()
  {
    $data = '{"jsonrpc": "2.0", "error": {"code": -32601, "message": "Method not found"}, "id": 1}';
    $expects = '';
    $fault = $this->getResponseFault($data);
    $this->assertEquals($expects, $fault);
  }

  public function testValidResponseErrorWithIdNull()
  {
    $data = '{"jsonrpc": "2.0", "error": {"code": -32600, "message": "Invalid Request"}, "id": null}';
    $expects = '';
    $fault = $this->getResponseFault($data);
    $this->assertEquals($expects, $fault);
  }

  public function testValidResponseIdWithIntegerZero()
  {
    $data = '{"jsonrpc": "2.0", "result": 6, "id": 0}';
    $expects = '';
    $fault = $this->getResponseFault($data);
    $this->assertEquals($expects, $fault);
  }

  public function testValidResponseIdWithString()
  {
    $data = '{"jsonrpc": "2.0", "result": 6, "id": "req1"}';
    $expects = '';
    $fault = $this->getResponseFault($data);
    $this->assertEquals($expects, $fault);
  }

  public function testInvalidResponseErrorWithIdNull()
  {
    $data = '{"jsonrpc": "2.0", "error": {"code": -32601, "message": "Method not found"}, "id": null}';
    $expects = Rpc::getErrorMsg('id');
    $fault = $this->getResponseFault($data);
    $this->assertEquals($expects, $fault);
  }

  public function testInvalidResponseResultAndErrorMissing()
  {
    $data = '{"jsonrpc": "2.0", "id": 1}';
    $expects = Rpc::getErrorMsg('result', false);
    $fault = $this->getResponseFault($data);
    $this->assertEquals($expects, $fault);
  }

  public function testInvalidResponseResultWithIdNull()
  {
    $data = '{"jsonrpc": "2.0", "result": 6, "id": null}';
    $expects = Rpc::getErrorMsg('id');
    $fault = $this->getResponseFault($data);
    $this->assertEquals($expects, $fault);
  }

  public function testInvalidResponseIdWithStringEmpty()
  {
    $data = '{"jsonrpc": "2.0", "result": 6, "id": ""}';
    $expects = Rpc::getErrorMsg('id');
    $fault = $this->getResponseFault($data);
    $this->assertEquals($expects, $fault);
  }

  public function testInvalidResponseIdWithFloat()
  {
    $data = '{"jsonrpc": "2.0", "result": 6, "id": 1.24}';
    $expects = Rpc::getErrorMsg('id');
    $fault = $this->getResponseFault($data);
    $this->assertEquals($expects, $fault);
  }

  public function testInvalidResponseIdWithTrue()
  {
    $data = '{"jsonrpc": "2.0", "result": 6, "id": true}';
    $expects = Rpc::getErrorMsg('id');
    $fault = $this->getResponseFault($data);
    $this->assertEquals($expects, $fault);
  }

  public function testInvalidResponseIdWithFalse()
  {
    $data = '{"jsonrpc": "2.0", "result": 6, "id": false}';
    $expects = Rpc::getErrorMsg('id');
    $fault = $this->getResponseFault($data);
    $this->assertEquals($expects, $fault);
  }


  public function testInvalidResponseIdWithArray()
  {
    $data = '{"jsonrpc": "2.0", "result": 6, "id": [1]}';
    $expects = Rpc::getErrorMsg('id');
    $fault = $this->getResponseFault($data);
    $this->assertEquals($expects, $fault);
  }

  public function testInvalidResponseWithObject()
  {
    $data = '{"jsonrpc": "2.0", "result": 6, "id": {"value": 1}}';
    $expects = Rpc::getErrorMsg('id');
    $fault = $this->getResponseFault($data);
    $this->assertEquals($expects, $fault);
  }


}
