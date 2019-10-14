<?php
Class Data {
    public $token = [];

    public function Testing(){
        return "Ada";
    }

    public function setToken($token){
        $this->token = $token;
    }

    public function getToken(){
        return $this->token;
    }

    public function access_token(){
        $curl = curl_init('http://graph.facebook.com');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);
        $res = json_decode(curl_exec($curl));
        curl_close();

        return $res;
    }
}