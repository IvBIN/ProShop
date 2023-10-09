<?php

namespace app\models;

use app\core\BaseModel;

class UsersModel extends BaseModel
{
    public function addNewUser($username, $login, $password, $avatar)
    {
        $password = password_hash($password, PASSWORD_DEFAULT);
        $avatar = file_get_contents($avatar);
        $avatar = base64_encode($avatar);
        return $this->insert(
            "INSERT INTO users (username, login, password, avatar) VALUES (:username, :login, :password, :avatar)",
            [
                'username' => $username,
                'login' => $login,
                'password' => $password,
                'avatar' => $avatar,
            ]
        );
    }

    public function authBylogin($login, $password)
    {
        $result = false;
        $error_message = '';
        if (empty($login)) {
            $error_message .= "Введите ваш логин!<br>";
        }
        if (empty($password)) {
            $error_message .= "Введите пароль!<br>";
        }
        if (empty($error_message)) {
            $users = $this->select('select * from users where login = :login', [
                'login' => $login
            ]);
            if (!empty($users[0])) {
                $passwordCorrect = password_verify($password, $users[0]['password']);
                if ($passwordCorrect) {
                    $_SESSION['user']['id'] = $users[0]['id'];
                    $_SESSION['user']['username'] = $users[0]['username'];
                    $_SESSION['user']['login'] = $users[0]['login'];
                    $_SESSION['user']['is_admin'] = ($users[0]['is_admin'] == '1');
                    $_SESSION['user']['avatar'] = $users[0]['avatar'];
                    $result = true;
                } else {
                    $error_message .= "Неверный логин или пароль! <br>";
                }
            } else {
                $error_message .= "Пользователь не найден! <br>";
            }
        }
        return [
            'result' => $result,
            'error_message' => $error_message
        ];
    }

    public function changePasswordByCurrentPassword($current_password, $new_password, $confirm_new_password)
    {
        $result = false;
        $error_message = '';

        if (empty($current_password)) {
            $error_message .= "Введите текущий пароль!<br>";
        }
        if (empty($new_password)) {
            $error_message .= "Введите новый пароль!<br>";
        }
        if (empty($confirm_new_password)) {
            $error_message .= "Повторите новый пароль!<br>";
        }
        if ($new_password != $confirm_new_password) {
            $error_message .= "Пароли не совпадают!<br>";
        }

        if (empty($error_message)) {
            $users = $this->select('select * from users where login = :login', [
                'login' =>$_SESSION['user']['login']
            ]);
            if (!empty($users[0])) {
                $passwordCorrect = password_verify($current_password, $users[0]['password']);

                if ($passwordCorrect) {
                    $new_password = password_hash($new_password, PASSWORD_DEFAULT);
                    $updatePassword = $this->update('update users set password = :password where login = :login', [
                        'login' =>$_SESSION['user']['login'],
                        'password' =>$new_password
                    ]);
                    $result = $updatePassword;
                } else {
                    $error_message .= "Неверный пароль!<br>";
                }
            } else {
                $error_message .= "Произошла ошибка при смене пароля!<br>";
            }
        }
        return [
            'result' => $result,
            'error_message' => $error_message
        ];
    }
    public function changeAvatar($current_avatar, $new_avatar)
    {
        $result = false;
        $error_message = '';
        $new_avatar = file_get_contents($new_avatar);
        $new_avatar = base64_encode($new_avatar);
        if (empty($current_avatar)) {
            $error_message .= "Добавьте аватар!<br>";
        }

        if (empty($error_message)) {
            $users = $this->select('select * from users where login = :login', [
                'login' =>$_SESSION['user']['login']
            ]);
            if (!empty($users[0])) {
                $avatarCorrect = base64_encode($current_avatar, $users[0]['avatar']);

                if ($avatarCorrect) {
                    $updateAvatar = $this->update('update users set avatar = :avatar where login = :login', [
                        'login' =>$_SESSION['user']['login'],
                        'avatar' =>$new_avatar
                    ]);
                    $result = $updateAvatar;
                } else {
                    $error_message .= "Файл не выбран!<br>";
                }
            } else {
                $error_message .= "Произошла ошибка при смене аватара!<br>";
            }
        }
        return [
            'result' => $result,
            'error_message' => $error_message
        ];
    }





    public function getListUsers()
    {
        $result = null;

        $users = $this->select('select id, username, login, is_admin from users');
        if (!empty($users)) {
            $result = $users;
        }
        return $result;
    }
}