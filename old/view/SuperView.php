<?php 

/**
 * 
 */
Abstract class StaticVariablesInheritance
{
	protected static $login = 'LoginView::Login';
	protected static $logout = 'LoginView::Logout';
	protected static $name = 'LoginView::UserName';
	protected static $password = 'LoginView::Password';
	protected static $cookieName = 'LoginView::CookieName';
	protected static $cookiePassword = 'LoginView::CookiePassword';
	protected static $keep = 'LoginView::KeepMeLoggedIn';
	protected static $messageId = 'LoginView::Message';
}