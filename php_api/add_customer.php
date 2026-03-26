<?php

include 'condb.php';

// รับค่า JSON จาก client
$input = file_get_contents("php://input");
$data = json_decode($input, true);

// เช็คว่าข้อมูลเป็น JSON หรือไม่
if (!$data) {
    http_response_code(400);
    echo json_encode([
        "status" => "error",
        "message" => "รูปแบบ JSON ไม่ถูกต้อง"
    ]);
    exit;
}

// เช็คว่าข้อมูลครบถ้วนหรือไม่
if (
    empty($data['firstName']) ||
    empty($data['lastName']) ||
    empty($data['phone']) ||
    empty($data['username']) ||
    empty($data['password'])
) {
    http_response_code(400);
    echo json_encode([
        "status" => "error",
        "message" => "กรุณากรอกข้อมูลให้ครบ"
    ]);
    exit;
}

// เข้ารหัสรหัสผ่าน
$password_hash = password_hash($data["password"], PASSWORD_BCRYPT);

try {
    // เพิ่มข้อมูลลูกค้า
    $sql = "INSERT INTO customers (firstName, lastName, phone, username, password)
            VALUES (:firstName, :lastName, :phone, :username, :password)";

    $stmt = $conn->prepare($sql);

    $stmt->bindParam(":firstName", $data['firstName']);
    $stmt->bindParam(":lastName", $data['lastName']);
    $stmt->bindParam(":phone", $data['phone']);
    $stmt->bindParam(":username", $data['username']);
    $stmt->bindParam(":password", $password_hash);

    if ($stmt->execute()) {
        http_response_code(201);
        echo json_encode([
            "status" => "success",
            "message" => "สมัครสมาชิกสำเร็จ"
        ]);
    } else {
        http_response_code(400);
        echo json_encode([
            "status" => "error",
            "message" => "ไม่สามารถเพิ่มข้อมูลได้"
        ]);
    }

} catch (PDOException $e) {
    http_response_code(500);
    // Check if it's a duplicate username error
    if (strpos($e->getMessage(), 'Duplicate entry') !== false) {
        echo json_encode([
            "status" => "error",
            "message" => "Username นี้มีผู้ใช้งานแล้ว"
        ]);
    } else {
        echo json_encode([
            "status" => "error",
            "message" => "ข้อผิดพลาดจากฐานข้อมูล: " . $e->getMessage()
        ]);
    }
}

?>