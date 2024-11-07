<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "your_database";

// إنشاء اتصال بقاعدة البيانات
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $booking_name = $_POST['booking_name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $type = $_POST['type'];  // نوع الحجز

    // التحقق مما إذا كان اسم الحجز أو الإيميل موجودًا بالفعل في قاعدة البيانات
    $check_sql = "SELECT * FROM bookings WHERE booking_name = ? ";
    $stmt = $conn->prepare($check_sql);
    $stmt->bind_param("s", $booking_name);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<script>alert('This Booking Name already exists!');
        window.location.href = '../index.php';</script>";
    } else {
        // إذا لم يتم العثور على البيانات، يتم إضافة الحجز
        $insert_sql = "INSERT INTO bookings (booking_name, email, password, type, archived) VALUES (?, ?, ?, ?, 0)";
        $stmt = $conn->prepare($insert_sql);
        $stmt->bind_param("ssss", $booking_name, $email, $password, $type);

        if ($stmt->execute()) {
            echo "<script>alert('Booking saved successfully!');
            window.location.href = '../uploud/work.php';</script>";
        } else {
            echo "Error: " . $stmt->error;
        }
    }

    $stmt->close();
}

$conn->close();
?>
