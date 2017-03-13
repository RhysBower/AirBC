<?php declare(strict_types=1);
namespace Airbc\Controllers;

use Airbc\Model\Account;
use Firebase\JWT\JWT;

/**
 * Controller for the Account page.
 */
class AccountController extends Controller
{
    const KEY = '9nwhBxeQ83dw6zrG2BEZTmUq77Fkq8eS';

    public function __construct()
    {
        parent::__construct();
    }

    public function account()
    {
        if ($this->isLoggedIn()) {
            $this->context['page'] = "account";

            $template = $this->twig->load('account.twig');
            echo $template->render($this->context);
        } else {
            header('Location: /login');
        }
    }

    public function login()
    {
        if ($this->isPublic()) {
            $this->context['page'] = "login";

            if ($_SERVER['REQUEST_METHOD'] === "POST" &&
                array_key_exists('username', $_POST) &&
                array_key_exists('password', $_POST)) {
                $username = $_POST['username'];
                $password = $_POST['password'];
                $account = $this->database->getUserAccount($username);
                if ($account === null) {
                    // User does not exist
                    $this->displayLoginPage();
                } else {
                    $verified = password_verify($password, $account->getPassword());
                    if ($verified) {
                        $this->logUserIn($account);
                    } else {
                        // Invalid credentials
                        $this->displayLoginPage();
                    }
                }
            } else {
                // Display regular login page
                $this->displayLoginPage();
            }
        } else {
            header('Location: /account');
        }
    }

    public function logout()
    {
        header('Location: /');
        setcookie('account', "", time()-1000);
    }

    private function displayLoginPage()
    {
        $template = $this->twig->load('login.twig');
        echo $template->render($this->context);
    }

    private function logUserIn(Account $account)
    {
        $iat = time();
        // Expire token in one week
        $exp = $iat + (7 * 24 * 60 * 60);
        $token = array(
            "iss" => "http://www.airbc.ca",
            "aud" => "http://www.airbc.ca",
            "iat" => $iat,
            "exp" => $exp,
            "sub" => $account->id
        );
        $jwt = JWT::encode($token, self::KEY);
        header('Location: /account');
        setcookie('account', $jwt, $exp);
    }

    private function verifyJwt($jwt):boolean
    {
        return JWT::decode($jwt, self::KEY, array('HS256'));
    }
}
