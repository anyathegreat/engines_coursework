<?php
class User
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function findUserByEmail($email)
    {
        $query = "SELECT * FROM users WHERE email = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function getAllUsers()
    {
        $query = "SELECT * FROM users";
        $result = $this->db->query($query);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getUserById($id)
    {
        $query = "SELECT * FROM users WHERE id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function createUser($email, $firstname, $lastname, $phone, $password, $password_confirm, $role = 'user')
    {
        $count = 0;
        // Проверка на уникальность email
        $query = "SELECT COUNT(*) FROM users WHERE email = ?";
        $stmt = $this->db->prepare($query);
        if ($stmt === false) {
            throw new Exception("Ошибка подготовки запроса: " . $this->db->error);
        }
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->bind_result($count);
        $stmt->fetch();
        $stmt->close();

        // Если email уже существует, выбрасываем исключение
        if ($count > 0) {
            throw new Exception("Email уже существует");
        }

        // Проверка на совпадение паролей
        if ($password !== $password_confirm) {
            throw new Exception("Пароли не совпадают");
        }

        // Хеширование пароля
        $password_hash = password_hash($password, PASSWORD_BCRYPT);

        // Вставка нового пользователя в таблицу users
        $query = "INSERT INTO users (email, password_hash, firstname, lastname, phone, role) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($query);
        if ($stmt === false) {
            throw new Exception("Ошибка подготовки запроса: " . $this->db->error);
        }
        $stmt->bind_param("ssssss", $email, $password_hash, $firstname, $lastname, $phone, $role);
        $result = $stmt->execute();

        // Закрываем подготовленный запрос
        $stmt->close();

        if (!$result) {
            throw new Exception("Не удалось создать пользователя");
        }

        return true; // Возвращаем true при успешном создании
    }

    public function updateUser($id, $email, $firstname, $lastname, $phone, $enabled, $role)
    {
        $query = "UPDATE users SET email = ?, firstname = ?, lastname = ?, phone = ?, `role` = ?, `enabled` = ? WHERE id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("sssssii", $email, $firstname, $lastname, $phone, $role, $enabled, $id);
        $isSuccess = $stmt->execute();
        if ($isSuccess) {
            $updatedUser = $this->getUserById($id);
            return $updatedUser;
        } else {
            return null;
        }
    }

    public function deleteUser($userId)
    {
        $query = "DELETE FROM users WHERE id = ?";
        $stmt = $this->db->prepare($query);
        if ($stmt === false) {
            throw new Exception("Ошибка подготовки запроса: " . $this->db->error);
        }
        $stmt->bind_param("i", $userId); // Параметр - id пользователя
        $result = $stmt->execute();
        $stmt->close();

        return $result; // Возвращаем результат выполнения (true или false)
    }
}
