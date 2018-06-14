<?php
namespace App;

use Carbon\Carbon;

class ApiResponse {
    private $statusCode;
    private $body;

    public function __construct($response) {
        $this->statusCode = $response->getStatusCode();
        $this->body = json_decode($response->getBody());

        if(is_null($this->body)) {
            $this->body = new \stdClass;
        } else {
            $this->body = (object)$this->body;
        }

        if(!isset($this->body->result)) {
            if(preg_match("/^2[0-9]{2}$/", $this->statusCode)) {
                $this->body->result = config('define.result.success');
            } else {
                $this->body->result = config('define.result.failure');
            }
        }
    }

    public function getStatusCode() {
        return $this->statusCode;
    }

    public function getBody() {
        return $this->body;
    }
}

?>
