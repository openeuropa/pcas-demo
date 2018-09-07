<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

/**
 * @SuppressWarnings(PHPMD)
 */
class RegisterController extends Controller
{
    /**
     * @Route("/register", name="register")
     */
    public function registerAction()
    {
        return new Response('This is an empty registration page.');
    }
}
