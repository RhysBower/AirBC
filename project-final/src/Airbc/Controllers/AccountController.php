<?php declare(strict_types=1);
namespace Airbc\Controllers;

use Airbc\Model\Account;
use Airbc\Model\Customer;
use Firebase\JWT\JWT;
use Airbc\Database;
use Airbc\Log;

/**
 * Controller for the Account page.
 */
class AccountController extends Controller
{
    const KEY = '9nwhBxeQ83dw6zrG2BEZTmUq77Fkq8eS';

    public function newAccountPage()
    {
        if ($this->isPublic()) {
            $this->context['page'] = "account";

            $template = $this->twig->load('new_account.twig');
            echo $template->render($this->context);
        } else {
            header('Location: /account');
        }
    }

    public function createAccount()
    {
        if ($this->isPublic()) {
            $this->context['page'] = "account";

            $this->currentUser = new Customer(0, "", "", "", "", "", "", "", "", "");
            $this->currentUser->name = $_POST['name'];
            $this->currentUser->email = $_POST['email'];
            $this->currentUser->username = $_POST['username'];
            $this->currentUser->travelDocument = $_POST['travel_document'];
            $this->currentUser->billingAddress = $_POST['billing_address'];
            $this->currentUser->phoneNumber = $_POST['phone_number'];
            $this->currentUser->seatPreference = $_POST['seat_preference'];
            $this->currentUser->paymentInformation = $_POST['payment_information'];
            $this->currentUser->setPassword($_POST['password']);
            if(Database::createCustomer($this->currentUser)) {
                $this->logUserIn(Database::getUserAccount($this->currentUser->username));
            } else {
                $this->context['error'] = 'Failed to create account';
                $this->context['currentUser'] = $this->currentUser;
                $template = $this->twig->load('new_account.twig');
                echo $template->render($this->context);
            }
        } else {
            header('Location: /account');
        }
    }

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

    public function updateAccount()
    {
        if ($this->isLoggedIn()) {
            $this->context['page'] = "account";

            $this->currentUser->name = $_POST['name'];
            $this->currentUser->email = $_POST['email'];
            $this->currentUser->username = $_POST['username'];
            if($this->isStaff()) {
                $this->currentUser->title = $_POST['title'];
                Database::updateStaff($this->currentUser);
            } else if ($this->isCustomer()) {
                $this->currentUser->travelDocument = $_POST['travel_document'];
                $this->currentUser->billingAddress = $_POST['billing_address'];
                $this->currentUser->phoneNumber = $_POST['phone_number'];
                $this->currentUser->seatPreference = $_POST['seat_preference'];
                $this->currentUser->paymentInformation = $_POST['payment_information'];
                Database::updateCustomer($this->currentUser);
            }

            $template = $this->twig->load('account.twig');
            echo $template->render($this->context);
        } else {
            header('Location: /login');
        }
    }
    public function updatePassword()
    {
        if ($this->isLoggedIn()) {
            $this->context['page'] = "account";

            $this->currentUser->setPassword($_POST['password']);
            Database::updateAccount($this->currentUser);

            header('Location: /account');
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
                    $this->context['error'] = "Invalid username or password!";
                    $this->displayLoginPage();
                } else {
                    $verified = password_verify($password, $account->getPassword());
                    if ($verified) {
                        $this->logUserIn($account);
                    } else {
                        // Invalid credentials
                        $this->context['error'] = "Invalid username or password!";
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
