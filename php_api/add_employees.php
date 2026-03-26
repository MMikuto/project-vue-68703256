<?php

include 'condb.php';

// รับค่า JSON จาก client
$data = json_decode(file_get_contents("php://input"), true);

// เช็คว่าข้อมูลครบถ้วนหรือไม่
if (
    empty($data['firstName']) ||
    empty($data['departmant']) ||
    empty($data['salary']) ||
    empty($data['active']) ||
) {
    echo json_encode([
        "status" => "error",
        "message" => "กรุณากรอกข้อมูลให้ครบ"
    ]);
    exit;
}
 // เช็คว่าข้อมูลเป็น JSON หรือไม่
if (!$data) {
    echo json_encode([
        "status" => "error",
        "message" => "รูปแบบ JSON ไม่ถูกต้อง"
    ]);
    exit;
}

  // เข้ารหัสรหัสผ่าน
    $password_hash = password_hash($data["password"], PASSWORD_BCRYPT);

    try {
         // เพิ่มข้อมูลลูกค้า
        $sql = "INSERT INTO employees (firstName, departmant, salary, active)
                VALUES (firstName, departmant, salary, active)";

        $stmt = $conn->prepare($sql);

        $stmt->bindParam(":firstName", $data['firstName']);
        $stmt->bindParam(":departmant", $data['departmant']);
        $stmt->bindParam(":salary", $data['salary']);
        $stmt->bindParam(":active", $data['active']);

        if ($stmt->execute()) {
            echo json_encode([
                "status" => "success",
                "message" => "เพิ่มข้อมูลเรียบร้อย"
            ]);
        } else {
            echo json_encode([
                "status" => "error",
                "message" => "ไม่สามารถเพิ่มข้อมูลได้"
            ]);
        }

    } catch (PDOException $e) {
        echo json_encode([
            "status" => "error",
            "message" => $e->getMessage()
        ]);
    }

?>