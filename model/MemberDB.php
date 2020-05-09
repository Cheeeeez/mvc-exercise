<?php


namespace Model;


class MemberDB
{
    public $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function create($member)
    {
        $sql = "INSERT INTO users(name, email, password) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $nickName = $member->getNickName();
        $email = $member->getEmail();
        $password = $member->getPassword();
        $stmt->bindParam(1, $nickName);
        $stmt->bindParam(2, $email);
        $stmt->bindParam(3, $password);
        return $stmt->execute();
    }

    public function get($email, $password)
    {
        $sql = "SELECT * FROM users WHERE email = ? AND password = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(1, $email);
        $stmt->bindParam(2, $password);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function getAll()
    {
        $sql = "SELECT CONCAT(m.lastname,' ',m.firstname) AS 'manager', 
                                             CONCAT(e.lastname,' ',e.firstname) AS 'employee',
                                             e.employeeNumber, e.jobTitle, offices.city
                                             FROM employees m 
                                             RIGHT JOIN employees e ON m.employeeNumber = e.reportsTo
                                             JOIN offices ON e.officeCode = offices.officeCode
                                             ORDER BY e.employeeNumber";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        $customers = [];
        foreach ($result as $item) {
            $customer = new Customer($item['name'], $item['email'], $item['address']);
            $customer->id = $item['id'];
            $customers[] = $customer;
        }
        return $customers;
    }
}