<?php
require_once('controllers/base_controller.php');
require_once('models/user.php');
// Start the session
session_start();
class UsersController extends BaseController
{
    function __construct()
    {
        $this->folder = 'users';
    }

    public function index()
    {
    }

    public function login()
    {
        if (isset($_SESSION['user'])) {
            header('Location: ./');
        }
        else {
            if (isset($_POST['username']) && isset($_POST['password'])) {
                $username = trim($_POST['username']);
                $password = trim($_POST['password']);
                if (!isset($username) || $username === '' || !isset($password) || $password === '') {
                    echo json_encode(array('success' => 0, 'msg' => 'Please enter username and password!'));
                }
                else {
                    $user = User::login($username, $password);
                    if (isset($user['id'])) {
                        echo json_encode(array('success' => 1));
                        $_SESSION['user'] = $user['username'];
                    }
                    else {
                        echo json_encode(array('success' => 0, 'msg' => 'Invalid username or password!'));
                    }
                }
            } else {
                $this->render('login');
            }
        }
    }

    public function logout()
    {
        session_destroy();
        header('Location: index.php?controller=users&action=login');
    }
}
?>
