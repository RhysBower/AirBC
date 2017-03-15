<?php declare(strict_types=1);
namespace Airbc\Controllers;

use Airbc\Object;
use Airbc\Log;
use Airbc\Database;
use Firebase\JWT\JWT;
use Firebase\JWT\SignatureInvalidException;

/**
 * Base controller for pages.
 * Configures logging, database connection, and Twig.
 * Page controllers should extend this class and implement page specific functionality.
 */
class Controller extends Object
{
    protected $database;
    protected $loader;
    protected $twig;
    private $currentUser;
    protected $context;

    public function __construct()
    {
        $this->database = new Database();

        $this->loader = new \Twig_Loader_Filesystem('templates', __DIR__."/../../");
        $this->twig = new \Twig_Environment($this->loader, array('debug' => true));
        $this->context = [];
        if (array_key_exists('account', $_COOKIE)) {
            $this->verifyAccount($_COOKIE['account']);
        }
        $this->context['currentUser'] = $this->currentUser;
    }

    private function verifyAccount($jwt)
    {
        try {
            $decoded = JWT::decode($jwt, AccountController::KEY, array('HS256'));
            $this->currentUser = $this->database->getAccount($decoded->sub);
            Log::info("Valid token used");
        } catch (SignatureInvalidException $e) {
            // Invalid token
            Log::info("Invalid token used");
            setcookie('account', "", time()-1000);
        }
    }

    public function isLoggedIn(): bool
    {
        return $this->currentUser !== null;
    }

    public function isPublic(): bool
    {
        return $this->currentUser === null;
    }

    public function isCustomer(): bool
    {
        try {
            $id = $this->currentUser->id;
            $isCustomer = $this->database->isCustomer($id);
            return $isCustomer;
        } catch (Exception $e) {
            Log::info($e->getMessage());
            return false;
        }
    }

    public function isLoyaltyMember(): bool
    {
        try {
            $id = $this->currentUser->id;
            $isLoyaltyMember = $this->database->isLoyaltyMember($id);
            return $isLoyaltyMember;
        } catch (Exception $e) {
            Log::info($e->getMessage());
            return false;
        }
    }

    public function isStaff(): bool
    {
        try {
            $id = $this->currentUser->id;
            $isStaff = $this->database->isStaff($id);
            return $isStaff;
        } catch (Exception $e) {
            Log::info($e->getMessage());
            return false;
        }
    }

    public function renderForbidden()
    {
        http_response_code(403);
        $template = $this->twig->load('403.twig');
        echo $template->render($this->context);
    }
}
