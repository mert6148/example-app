<?php

namespace App\Exception;

use Symfony\Component\HttpFoundation\Response;

class  UserNotFoundException extends \Exception
{
    public function __construct()
    {
        if (isset($_SESSION['user'])) {
            foreach ($_SESSION['user'] as $key => $value) {
                while ($key != 'id') {
                    $id = $value;
                }
            }
        }
    }

    public function getResponse()
    {
        return new Response('User with id ' . $id . ' not found', 404);
    }
}
