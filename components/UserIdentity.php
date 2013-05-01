<?php 
/**
* 
*/
class UserIdentity
{
	protected $_id = null;
	protected $username = null;

	public function __construct()
	{
		session_start();
		//if already login then set attributes.
		if(isset($_SESSION['_id']) && isset($_SESSION['username']))
		{
			$this->_id = $_SESSION['_id'];
			$this->username = $_SESSION['username'];
		}
	}

	public function login($username, $password)
	{
		if($this->_id===null)
		{
			$user_model = new User();
			if($user_model->validate($username, $password))
			{
				$user = $user_model->getUserByUsername($username);
				$_SESSION['_id'] = $this->_id = $user['id'];
				$_SESSION['username'] = $this->username = $user['username'];

				return $this->_id;
			}
			else
			{
				return false;
			}
		}
		else
		{
			//already login
			return $this->_id;
		}
	}

	public function logout()
	{
		$this->_id = null;
		$this->username = null;
		unset($_SESSION['_id']);
		unset($_SESSION['username']);
	}

	public function isLogin()
	{
		return $this->_id!==null && is_int($this->_id);
	}

	public function getId()
	{
		return $this->_id;
	}

	public function getUsername()
	{
		return $this->username;
	}
}
?>