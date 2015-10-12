<?php 

class RedditConnect {
    protected $username;
    protected $password;
    protected $client_id;
    protected $client_secret;

    protected $access_token_endpoint = 'https://www.reddit.com/api/v1/access_token';
    protected $reddit_my_info = 'https://oauth.reddit.com/api/v1/me';

    public function __construct($username, $password, $client_id, $client_secret) {
        $this->username = $username;
        $this->password = $password;
        $this->client_id = $client_id;
        $this->client_secret = $client_secret;
    }

    public function get_token() {
        return $this->execture_curl();
    }

    public function get_my_info($token) {
        return $this->execture_curl($token);
    }

    private function execture_curl($token = null) {

        $endpoint = !$token ? $this->access_token_endpoint : $this->reddit_my_info;
        $ch = curl_init($endpoint);

        // get token call
        if (!$token) {
            
            $fields = array (
                'grant_type' => 'password',
                'username' => $this->username,
                'password' => $this->password,
            );
            $field_string = http_build_query($fields);

            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Basic ' . base64_encode($this->client_id . ':' . $this->client_secret)));
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $field_string);
        // call reddit api
        } else {
            curl_setopt($ch, CURLOPT_HTTPHEADER, ['Authorization: Bearer '. $token]);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_USERAGENT, 'afs35mm reddit messenger service');
        }

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $data = curl_exec($ch);
        curl_close($ch);

        return $data;

    }
}
