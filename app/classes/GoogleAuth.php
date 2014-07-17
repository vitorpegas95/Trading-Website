<?php
	class GoogleAuth
	{
		protected $client;
		protected $db;
		
		public function __construct(Database $db = null, Google_Client $googleClient = null)
		{
			$this->client = $googleClient;
			$this->db = $db;
			if($this->client)
			{
				$this->client->setClientId('CLIENT ID');
				$this->client->setClientSecret('CLIENT SECRET');
				$this->client->setRedirectUri('http://localhost/marketplace/register.php');
				$this->client->setScopes('email'); //this will get the email of the user only.
			}
		}
		
		public function getAuthUrl()
		{
			return $this->client->createAuthUrl();
		}
		
		public function checkRedirectCode()
		{
			if(isset($_GET["code"]))
			{
				$this->client->authenticate($_GET["code"]);
				
				$this->setToken($this->client->getAccessToken());
				
				$this->storeUser($this->getPayload());
				
				return true;
			}
			
			return false;
		}
		
		public function setToken($token)
		{
			$_SESSION["access_token"] = $token;
			
			$this->client->setAccessToken($token);
		}
		
		public function logout()
		{
			unset($_SESSION["access_token"]);
		}
		
		protected function getPayload()
		{
			$payload = $this->client->verifyIdToken()->getAttributes();
			$payload = $payload["payload"];
			
			return $payload;
		}
		
		public function storeUser($payload)
		{
			$userid = $payload["id"];
			$email = $payload["email"];
			
			$username = explode("@", $email);
			$name = $username[0] . "g";
			
			$password = Hash512("google" . rand(0, 99999) . "login");
		
			$this->db->Execute("INSERT INTO `accounts`(`googleid`, `username`, `password`, `nome`, `email`) VALUES (?,?,?,?,?)", Escape($userid), Escape($name), $password, Escape($name), Escape($email));
			
			$_SESSION["username"] = $name;
		}
	}
?>
