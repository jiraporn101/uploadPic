<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>ระบบลงทะเบียนอบรม</title>
    <style>
        /* ส่วนตกแต่งสีสัน (CSS) */
        body {
            font-family: 'Sarabun', sans-serif;
            background-color: #f4f7f6;
            margin: 0;
            padding: 20px;
            color: #333;
        }
        .container {
            max-width: 800px;
            margin: auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        h2 { color: #2c3e50; border-bottom: 2px solid #3498db; padding-bottom: 10px; }
        h3 { color: #2980b9; margin-top: 25px; }
        
        /* ตกแต่งฟอร์ม */
        form { background: #fdfdfd; padding: 20px; border: 1px solid #eee; border-radius: 8px; }
        input[type="text"], input[type="email"], select {
            width: 100%; padding: 10px; margin: 8px 0; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box;
        }
        button {
            background-color: #3498db; color: white; border: none; padding: 10px 20px; border-radius: 4px; cursor: pointer; font-size: 16px;
        }
        button:hover { background-color: #2980b9; }

        /* ตกแต่งตาราง */
        table { width: 100%; border-collapse: collapse; margin-top: 15px; background: white; }
        th { background-color: #3498db; color: white; padding: 12px; text-align: left; }
        td { padding: 10px; border: 1px solid #eee; }
        tr:nth-child(even) { background-color: #f9f9f9; }

        /* กล่องแจ้งเตือนสำเร็จ */
        .success-box {
            background-color: #d4edda; color: #155724; padding: 15px; border-radius: 5px; border: 1px solid #c3e6cb; margin-top: 20px;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>ฟอร์มลงทะเบียนอบรม</h2>
    <form method="post">
        ชื่อ-นามสกุล: <br>
        <input type="text" name="fullname" required><br><br>

        Email: <br>
        <input type="email" name="email" required><br><br>

        หัวข้ออบรม: <br>
        <select name="course">
            <option value="AI สำหรับงานสำนักงาน">AI สำหรับงานสำนักงาน</option>
            <option value="Excel สำหรับการทำงาน">Excel สำหรับการทำงาน</option>
            <option value="การเขียนเว็บด้วย PHP">การเขียนเว็บด้วย PHP</option>
        </select><br><br>

        อาหารที่ต้องการ: <br>
        <input type="checkbox" name="food[]" value="ปกติ"> ปกติ
        <input type="checkbox" name="food[]" value="มังสวิรัติ"> มังสวิรัติ
        <input type="checkbox" name="food[]" value="ฮาลาล"> ฮาลาล
        <br><br>

        รูปแบบการเข้าร่วม: <br>
        <input type="radio" name="type" value="Onsite" required> Onsite
        <input type="radio" name="type" value="Online"> Online
        <br><br>

        <button type="submit" name="submit">ลงทะเบียน</button>
    </form>

    <?php
    // ส่วนที่ 2: โค้ดรับค่าจากฟอร์ม และ ประมวลผล
    if (isset($_POST['submit'])) {
        $fullname = $_POST['fullname'];
        $email = $_POST['email'];
        $course = $_POST['course'];
        $type = $_POST['type'];
        
        // อาหาร (Checkbox)
        if (isset($_POST['food'])) {
            $food = implode(",", $_POST['food']);
        } else {
            $food = "ไม่ระบุ";
        }

        // ค่าลงทะเบียน
        if ($type == "Onsite") {
            $price = 1500;
        } else {
            $price = 800;
        }

        // บันทึกลงไฟล์
        $data = $fullname . "|" . $email . "|" . $course . "|" . $food . "|" . $type . "|" . $price . "\n";
        file_put_contents("register.txt", $data, FILE_APPEND);

        // แสดงผล
        echo "<div class='success-box'>";
        echo "<h3>ลงทะเบียนสำเร็จ</h3>";
        echo "ชื่อ: $fullname <br>";
        echo "อีเมล: $email <br>";
        echo "หัวข้ออบรม: $course <br>";
        echo "อาหาร: $food <br>";
        echo "รูปแบบ: $type <br>";
        echo "ค่าลงทะเบียน: " . number_format($price, 2) . " บาท<br>";
        echo "</div>";
    }
    ?>

    <hr>

    <h3>รายชื่อผู้ลงทะเบียนทั้งหมด</h3>
    <?php
    if (file_exists("register.txt")) {
        $lines = file("register.txt");
        echo "<table>";
        echo "<tr>
                <th>ชื่อ</th>
                <th>Email</th>
                <th>หัวข้อ</th>
                <th>อาหาร</th>
                <th>รูปแบบ</th>
                <th>ค่าลงทะเบียน</th>
              </tr>";

        foreach ($lines as $line) {
            $trimmed_line = trim($line);
            if (!empty($trimmed_line)) {
                list($_name, $_email, $_course, $_food, $_type, $_price) = explode("|", $trimmed_line);
                echo "<tr>
                        <td>$_name</td>
                        <td>$_email</td>
                        <td>$_course</td>
                        <td>$_food</td>
                        <td>$_type</td>
                        <td>" . number_format($_price, 2) . "</td>
                      </tr>";
            }
        }
        echo "</table>";
    }
    ?>
</div>

</body>
</html>