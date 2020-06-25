<?php
class User
{
    public $id;
    public $username;
    public $phone;
    public $email;
    public $birthday;
    public $address;

    function __construct($id, $username, $phone, $email, $birthday, $address)
    {
        $this->id = $id;
        $this->username = $username;
        $this->phone = $phone;
        $this->email = $email;
        $this->birthday = $birthday;
        $this->address = $address;
    }

    static function all()
    {
        $list = [];
        $db = DB::getInstance();
        $req = $db->query('SELECT * FROM users');

        foreach ($req->fetchAll() as $item) {
            $list[] = new User($item['id'], $item['username'], $item['phone'], $item['email'], $item['birthday'], $item['address']);
        }

        return $list;
    }

    static function find($id)
    {
        $db = DB::getInstance();
        $req = $db->prepare('SELECT * FROM users WHERE id = :id');
        $req->execute(array('id' => $id));

        $item = $req->fetch();
        if (isset($item['id'])) {
            return new User($item['id'], $item['username'], $item['phone'], $item['email'], $item['birthday'], $item['address']);
        }
        return null;
    }

    static function login($username, $password)
    {
        $db = DB::getInstance();
        $req = $db->prepare('SELECT * FROM users WHERE username = :username AND password = :password');
        $req->execute(['username' => $username, 'password' => $password]);

        $item = $req->fetch();
        
        return $item;
    }
}
?>
