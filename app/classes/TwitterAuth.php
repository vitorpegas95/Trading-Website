<?php
class TwitterAuth
{
	protected $db;
	protected $client;
	
	protected $clientCallback = "http://localhost/marketplace/callback.php";
	
	public function __construct(Database $db, \Codebird\Codebird $client)
	{
		$this->client = $client;
		$this->db = $db;
	}
	
	public function getAuthUrl()
	{
		$this->requestTokens();
		$this->verifyTokens();
		
		return $this->client->oauth_authenticate();
	}	
	
	public function signedIn()
	{
		return isset($_SESSION['username']);
	}
	
	public function signOut()
	{
		unset($_SESSION['username']);
	}
	
	public function signIn()
	{
		if($this->hasCallback())
		{
			$this->verifyTokens();
			
			$reply = $this->client->oauth_accessToken(
			array(
				'oauth_verifier' => $_GET['oauth_verifier']
			));
			
			if($reply->httpstatus === 200)
			{
				//Success
				$this->storeTokens($reply->oauth_token, $reply->oauth_token_secret);
				$_SESSION['username'] = $reply->screen_name;
				
				//Store the user in DB
				
				$this->storeUser($reply);
				return true;
			}
			
			return true;
		}
		
		return false;
	}
	
	public function hasCallback()
	{
		return isset($_GET['oauth_verifier']);
	}
	
	public function requestTokens()
	{
		$reply = $this->client->oauth_requestToken(array(
			'oauth_callback' => $this->clientCallback
		));
		
		$this->storeTokens($reply->oauth_token, $reply->oauth_token_secret);
	}	
	
	protected function storeTokens($token ,$tokenSecret)
	{
		$_SESSION['oauth_token'] = $token;
		$_SESSION['oauth_token_secret'] = $tokenSecret;
	}
	
	protected function verifyTokens()
	{
		$this->client->setToken($_SESSION['oauth_token'], $_SESSION['oauth_token_secret']);
	}
	
	protected function storeUser($c)
	{
		$userid = $c->user_id;
		$name = $c->screen_name;
		$password = Hash512("twitter" . Rand(0, 199999));
		$this->db->Execute("INSERT INTO `accounts`(`twitterid`, `username`, `password`, `nome`) VALUES (?,?,?,?)", Escape($userid), Escape($name), $password, Escape($name));
	}
}
?>
