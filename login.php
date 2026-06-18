<?php
session_start();
include('db.php');

$login_error = "";
$register_error = "";
$register_success = "";

// ثبت نام
if (isset($_POST['register'])) {
    $reg_username = trim($_POST['reg_username']);
    $reg_password = trim($_POST['reg_password']);
    $reg_password_confirm = trim($_POST['reg_password_confirm']);

    if ($reg_username == "" || $reg_password == "" || $reg_password_confirm == "") {
        $register_error = "تمام فیلدها باید پر شوند.";
    } elseif ($reg_password !== $reg_password_confirm) {
        $register_error = "رمز عبور و تکرار آن مطابقت ندارند.";
    } elseif ($reg_username === 'sharifi') {
        $register_error = "نام کاربری 'sharifi' رزرو شده است.";
    } else {
        $stmt = $conn->prepare("SELECT id FROM users WHERE username=?"); // تغییر جدول به 'users'
        $stmt->bind_param("s", $reg_username);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            $register_error = "نام کاربری قبلاً ثبت شده است.";
        } else {
            $stmt->close();
            $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)"); // تغییر جدول به 'users'
            $stmt->bind_param("ss", $reg_username, $reg_password);
            if ($stmt->execute()) {
                $register_success = "ثبت نام با موفقیت انجام شد. لطفاً وارد شوید.";
            } else {
                $register_error = "خطا در ثبت نام.";
            }
        }
        $stmt->close();
    }
}

// ورود
if (isset($_POST['login'])) {
    $login_username = trim($_POST['login_username']);
    $login_password = trim($_POST['login_password']);

    if ($login_username === 'sharifi' && $login_password === '1382') {
        $_SESSION['username'] = 'sharifi';
        header('Location: index.php');
        exit;
    } else {
        $stmt = $conn->prepare("SELECT id FROM users WHERE username=? AND password=?"); // تغییر جدول به 'users'
        $stmt->bind_param("ss", $login_username, $login_password);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows === 1) {
            $_SESSION['username'] = $login_username;
            header('Location: index.php');
            exit;
        } else {
            $login_error = "نام کاربری یا رمز عبور اشتباه است.";
        }
        $stmt->close();
    }
}
?>

<!doctype html>
<html lang="fa">
<head>
<meta charset="utf-8">
<title>ورود / ثبت نام</title>

<link rel="stylesheet" href="css/login.css">
</head>
<body>

<div class="container">
    <h2>ورود کاربران</h2>
    <?php if ($login_error): ?><div class="message"><?php echo $login_error; ?></div><?php endif; ?>
    
    <form id="login-form" method="post" style="display: block;">
        <input type="text" name="login_username" placeholder="نام کاربری" required>
        <input type="password" name="login_password" placeholder="رمز عبور" required>
        <button type="submit" name="login">ورود</button>
    </form>

    <div class="toggle-link" id="show-register">اگر حساب ندارید، ثبت‌نام کنید</div>

    <form id="register-form" method="post" style="display: none;">
        <h2>ثبت نام</h2>
        <?php if ($register_error): ?><div class="message"><?php echo $register_error; ?></div><?php endif; ?>
        <?php if ($register_success): ?><div class="success"><?php echo $register_success; ?></div><?php endif; ?>
        <input type="text" name="reg_username" placeholder="نام کاربری جدید" required>
        <input type="password" name="reg_password" placeholder="رمز عبور" required>
        <input type="password" name="reg_password_confirm" placeholder="تکرار رمز عبور" required>
        <button type="submit" name="register">ثبت نام</button>
    </form>

    <div class="toggle-link" id="show-login" style="display:none;">بازگشت به ورود</div>
</div>

<script>
    const showRegisterLink = document.getElementById('show-register');
    const showLoginLink = document.getElementById('show-login');
    const loginForm = document.getElementById('login-form');
    const registerForm = document.getElementById('register-form');

    showRegisterLink.addEventListener('click', function() {
        loginForm.style.display = 'none';
        registerForm.style.display = 'block';
        showRegisterLink.style.display = 'none';
        showLoginLink.style.display = 'block';
    });

    showLoginLink.addEventListener('click', function() {
        loginForm.style.display = 'block';
        registerForm.style.display = 'none';
        showRegisterLink.style.display = 'block';
        showLoginLink.style.display = 'none';
    });
</script>

</body>
</html>
