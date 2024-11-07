<?php
// الاتصال بقاعدة البيانات
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "your_database";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// تحقق من وجود معرّف الحجز في الرابط وحذفه
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // تنفيذ استعلام حذف الحجز
    $sql = "DELETE FROM bookings WHERE id = ?";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            echo "<script>alert('Booking deleted successfully!');</script>";
        } else {
            echo "<script>alert('Error deleting booking');</script>";
        }
        $stmt->close();
    }
}

// استرجاع البيانات المؤرشفة
$sql = "SELECT * FROM bookings WHERE archived = 1";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Archived Bookings</title>
    <style>
        /* إضافة الأنماط الخاصة بالـ Navbar */
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #333;
            padding: 10px 20px;
            position: fixed;
            width: 100%;
            top: 0;
            left: 0;
            z-index: 1000;
        }

        .navbar .logo a {
            color: white;
            font-size: 24px;
            font-weight: bold;
            text-decoration: none;
        }

        .nav-links {
            display: flex;
            list-style: none;
            margin: 0;
            padding: 0;
        }

        .nav-links li {
            margin: 0 15px;
        }

        .nav-links a {
            color: white;
            text-decoration: none;
            font-size: 18px;
            padding: 8px 15px;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .nav-links a:hover {
            background-color: #f1c40f;
            color: #333;
        }

        /* بقية الأنماط الخاصة بالصفحة */
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 80%;
            max-width: 1000px;
        }

        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 12px;
            text-align: center;
        }

        th {
            background-color: #4CAF50;
            color: white;
        }

        td {
            background-color: #f4f4f4;
        }

        button {
            background-color: #007bff;
            color: white;
            padding: 8px 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }

        .return-btn {
            background-color: #28a745;
            margin-top: 10px;
            cursor: pointer;
        }

        .return-btn:hover {
            background-color: #218838;
        }
    </style>
    <script>
        // دالة تأكيد الحذف
        function confirmDelete(id) {
            // عرض نافذة تأكيد قبل الحذف
            if (confirm("Are you sure you want to delete this booking?")) {
                // إذا وافق المستخدم، سيتم إعادة التوجيه إلى صفحة الحذف
                window.location.href = "view_archive.php?id=" + id;
            }
        }
    </script>
</head>
<body>

<!-- تضمين Navbar -->
<?php include('../nav/nav.php'); ?>

<div class="container">
    <h1>Archived Bookings</h1>
    <table>
        <thead>
            <tr>
                <th>Booking Name</th>
                <th>Email</th>
                <th>Type</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // التحقق من وجود بيانات
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>" . $row['booking_name'] . "</td>
                            <td>" . $row['email'] . "</td>
                            <td>" . $row['type'] . "</td>
                            <td>
                                <button onclick='confirmDelete(" . $row['id'] . ")' class='btn btn-danger'>Delete</button>
                            </td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='4'>No archived bookings found</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

</body>
</html>

<?php
$conn->close();
?>
