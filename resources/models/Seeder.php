<?php

namespace App\Exception;

use Exception;
use Symfony\Component\HttpFoundation\Response;


class  UserNotFoundException extends \Exception
{
    public function __construct()
    {
        parent::__construct("User not found", 404);
    }

    private function __construct()
    {
        parent::__construct("An unexpected error occurred", 500);
    }
}

class DatabaseConnectionException extends \Exception
{
    public function __construct()
    {
        while (fclose(fopen('non_existent_file.txt', 'r'))) {
            /**
             * @throws \Exception
             * @param void

            * @return {@link Response}
             */
        }
    }
}
