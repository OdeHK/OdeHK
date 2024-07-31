<?php
session_start();

class SessionManager
{
	public static function logout()
	{
		session_destroy();
	}
	
	/*
		Params
			- username: String
			- role: Integer
	*/
	
	public static function login($username, $userId, $role, $fullname="")
	{
		// Regenerate session to avoid session fixation
		// https://youtu.be/UYLie3JEV2Y?si=IJTqULvMLrTR98zC
		// (Sessions in PHP: prevent session fixation attacks)
		session_regenerate_id(true);
		
		$_SESSION['logged'] = true;
		$_SESSION['role'] = $role;
		$_SESSION['username'] = $username;
		$_SESSION['userId'] = $userId;
		$_SESSION['fullname'] = $fullname;
		
	}
	
	public static function isUserLoggedIn()
	{
		if(isset($_SESSION['logged']) && $_SESSION['logged'])
		{
			return true;
		}
		
		return false;
	}
	
	public static function debugSessionInfo()
	{
		//print_r($_SESSION);
	}
	
	public static function isAdmin()
	{
		if (SessionManager::isUserLoggedIn() && $_SESSION['role'] == 1)
		{
			return true;
		}
		
		return false;
	}
	
	public static function getUserName()
	{
		if(SessionManager::isUserLoggedIn())
		{
			return $_SESSION['username'];
		}
		
		return "Guest";
	}
	
	public static function getFullname()
	{
		if(SessionManager::isUserLoggedIn())
		{
			return $_SESSION['fullname'];
		}
		
		return "Guest";
	}
	
	public static function getUserId()
	{
		if(SessionManager::isUserLoggedIn())
		{
			return $_SESSION['userId'];
		}
		
		return 0;
	}
	
	
}