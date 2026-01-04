<?php

namespace Src\Controller;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Eloquent\Model;

class BaseController extends Model
{
    public function __construct()
    {
        $capsule = new Capsule;
        $capsule->addConnection([
            'driver' => 'mysql',
            'host' => 'localhost',
            'database' => 'test',
            'username' => 'root',
            'password' => '',
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => '',
        ]);
        $capsule->setAsGlobal();
        $capsule->bootEloquent();
    }

    public function get()
    {
        $users = Capsule::table('users')->get();
        $users = json_encode($users);
        $users = json_decode($users, true);
        $users = array_map(function ($user) {
            return [
                'id' => $user['id'],
                'name' => $user['name'],
                'email' => $user['email'],
                'created_at' => $user['created_at'],
                'updated_at' => $user['updated_at'],
                'links' => [
                    'self' => '/users/' . $user['id'],
                    'posts' => '/users/' . $user['id'] . '/posts',
                    'comments' => '/users/' . $user['id'] . '/comments',
                    'profile' => '/users/' . $user['id'] . '/profile'
                ]
            ];
        }, $users);
        return $users;
    }

    public function find($id)
    {
        $user = Capsule::table('users')->where('id', $id)->first();
        $user = json_encode($user);
        $user = json_decode($user, true);
        $user = [
            'id' => $user['id'],
            'name' => $user['name'],
            'email' => $user['email'],
            'created_at' => $user['created_at'],
            'updated_at' => $user['updated_at'],
            'links' => [
                'self' => '/users/' . $user['id'],
                'posts' => '/users/' . $user['id'] . '/posts',
                'comments' => '/users/' . $user['id'] . '/comments',
                'profile' => '/users/' . $user['id'] . '/profile'
            ]
        ];
        return $user;
    }
}

class UserController extends BaseController
{
    public function __construct()
    {
        if (!isset($_SESSION)) {
            session_start();
            if (!isset($_SESSION['user'])) {
                $_SESSION['user'] = [];
            }
        }
    }

    public function index()
    {
        if (isset($_SESSION['user']['id'])) {
            return $this->show($_SESSION['user']['id']);
        } else {
            if (isset($_SESSION['user']['name'])) {
                foreach ($_SESSION['user'] as $key => $value) {
                    unset($_SESSION['user'][$key]);
                }
                unset($_SESSION['user']['name']);
            }
            return $this->get();
        }
    }

    public function show($id)
    {
        foreach ($_SESSION['user'] as $key => $value) {
            while ($key != 'id' && $key != 'name') {
                unset($_SESSION['user'][$key]);
            }
        }
    }
}

class PostController extends BaseController
{
    public function __construct()
    {
        if (!isset($_SESSION)) {
            session_start();
            if (!isset($_SESSION['user'])) {
                $_SESSION['user'] = [];
            }
        }
    }

    public function index()
    {
        if (isset($_SESSION['user']['id'])) {
            return $this->get();
        } else {
            if (isset($_SESSION['user']['name'])) {
                foreach ($_SESSION['user'] as $key => $value) {
                    unset($_SESSION['user'][$key]);
                }
                unset($_SESSION['user']['name']);
            }
            return $this->get();
        }
    }

    public function show($id)
    {
        if (isset($_SESSION['user']['id'])) {
            return $this->find($id);
        } else {
            if (isset($_SESSION['user']['name'])) {
                foreach ($_SESSION['user'] as $key => $value) {
                    unset($_SESSION['user'][$key]);
                }
                unset($_SESSION['user']['name']);
            }
            return $this->find($id);
        }
    }
}
