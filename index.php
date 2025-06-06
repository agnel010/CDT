<?php
$servername = "my-mysql";
$username = "root";
$password = "root";
$dbname = "CountDownTimer";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $sql = "INSERT INTO users (username, password) 
            VALUES ('$username', '$password')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>
                alert('Signup successful!');
                window.location.href='login.php';
              </script>";
    } else {
        echo "<script>
                alert('Error: " . $conn->error . "');
                window.location.href='index.php';
              </script>";
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Inter", "Poppins", -apple-system, BlinkMacSystemFont, sans-serif;
        }

        input {
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            border: none;
            outline: none;
        }

        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 0;
        }

        .outer-box {
            width: 100%;
            height: 100vh;
            position: relative;
            overflow: hidden;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .inner-box {
            width: 100%;
            max-width: 420px;
            margin: 0 auto;
            padding: 2rem;
            position: relative;
            background: linear-gradient(135deg, #7b2cbf 0%, #5a189a 100%);
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2),
                       0 1px 3px rgba(0, 0, 0, 0.1);
            text-align: center;
            color: #ffffff;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .inner-box:hover {
            transform: scale(1.02);
            box-shadow: 0 12px 35px rgba(0, 0, 0, 0.25);
        }

        .signup-header h1 {
            font-size: 2rem;
            font-weight: 600;
            color: #ffffff;
            margin-bottom: 1rem;
            letter-spacing: -0.025em;
        }

        .signup-header p {
            font-size: 0.95rem;
            color: #e9d8fd;
            margin-bottom: 1.5rem;
        }

        .signup-body {
            margin: 1.5rem 0;
        }

        .signup-body p {
            margin: 1rem 0;
            position: relative;
        }

        .signup-body p:has(.password-container) {
            margin-bottom: 0.25rem;
        }

        .signup-body p label {
            display: block;
            font-weight: 500;
            color: #ffffff;
            margin-bottom: 0.5rem;
            text-align: left;
        }

        .signup-body p input {
            width: 100%;
            padding: 12px;
            border: 1px solid #d6bcfa;
            border-radius: 8px;
            font-size: 1rem;
            background: rgba(255, 255, 255, 0.9);
            color: #2d3748;
            transition: all 0.2s ease;
            box-sizing: border-box;
            height: 48px;
            line-height: normal;
        }

        .signup-body p input::placeholder {
            font-size: 1rem;
            font-family: "Inter", "Poppins", -apple-system, BlinkMacSystemFont, sans-serif;
            color: #666666;
            opacity: 1;
            font-weight: 400;
            letter-spacing: normal;
            text-transform: none;
        }

        .signup-body p input::-webkit-input-placeholder {
            font-size: 1rem;
            font-family: "Inter", "Poppins", -apple-system, BlinkMacSystemFont, sans-serif;
            color: #666666;
            opacity: 1;
            font-weight: 400;
            letter-spacing: normal;
            text-transform: none;
        }

        .signup-body p input::-moz-placeholder {
            font-size: 1rem;
            font-family: "Inter", "Poppins", -apple-system, BlinkMacSystemFont, sans-serif;
            color: #666666;
            opacity: 1;
            font-weight: 400;
            letter-spacing: normal;
            text-transform: none;
        }

        .signup-body p input::-ms-input-placeholder {
            font-size: 1rem;
            font-family: "Inter", "Poppins", -apple-system, BlinkMacSystemFont, sans-serif;
            color: #666666;
            opacity: 1;
            font-weight: 400;
            letter-spacing: normal;
            text-transform: none;
        }

        .password-container input::placeholder {
            color: #666666 !important;
            opacity: 1 !important;
            font-weight: 400 !important;
        }

        .password-container input::-webkit-input-placeholder {
            color: #666666 !important;
            opacity: 1 !important;
            font-weight: 400 !important;
        }

        .password-container input::-moz-placeholder {
            color: #666666 !important;
            opacity: 1 !important;
            font-weight: 400 !important;
        }

        .password-container input::-ms-input-placeholder {
            color: #666666 !important;
            opacity: 1 !important;
            font-weight: 400 !important;
        }

        .signup-body p input:focus {
            outline: none !important;
            border-color: #b794f4;
            box-shadow: 0 0 0 3px rgba(183, 148, 244, 0.3);
        }

        .signup-body p input[type="submit"] {
            background: linear-gradient(135deg, #48bb78 0%, #2f855a 100%);
            border: none;
            color: #ffffff;
            cursor: pointer;
            font-weight: 500;
            padding: 12px;
            margin-top: 0.5rem;
            transition: all 0.3s ease;
            height: auto;
        }

        .signup-body p input[type="submit"]:hover {
            background: linear-gradient(135deg, #38a169 0%, #276749 100%);
            transform: scale(1.02);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }

        .signup-footer p {
            color: #e9d8fd;
            font-size: 0.9rem;
            margin-top: 1.5rem;
        }

        .signup-footer p a {
            color: #b794f4;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.2s ease;
        }

        .circle {
            width: 250px;
            height: 250px;
            border-radius: 16px;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.1), rgba(255, 255, 255, 0.3));
            position: fixed;
            animation: float 6s ease-in-out infinite;
        }

        .c1 {
            top: 50px;
            left: 40px;
            animation-delay: 0s;
        }

        .c2 {
            bottom: 50px;
            right: 50px;
            animation-delay: 0s;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-30px); }
        }

        .password-container {
            position: relative;
            width: 100%;
            bottom: 8px;
        }

        .password-container input {
            width: 100%;
            padding: 12px;
            padding-right: 40px;
            box-sizing: border-box;
            border-radius: 8px;
            height: 48px;
            border: 1px solid #d6bcfa;
            background: rgba(255, 255, 255, 0.9);
            color: #2d3748;
            font-size: 1rem;
            transition: all 0.2s ease;
        }

        .password-container input:focus {
            outline: none !important;
            border-color: #b794f4;
            box-shadow: 0 0 0 3px rgba(183, 148, 244, 0.3);
        }

        .toggle-password {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #2d3748;
            font-size: 1rem;
            line-height: 1;
            pointer-events: auto;
        }
    </style>
</head>
<body>
    <div class="outer-box">
        <div class="inner-box">
            <header class="signup-header">
                <h1>Sign up</h1>
                <p>It just takes 30 seconds</p>
            </header>
            <main class="signup-body">
                <form action="index.php" method="POST">
                    <p>
                        <label for="username">Username</label>
                        <input type="text" name="username" id="username" placeholder="Enter your username" required>
                    </p>
                    <p>
                        <label for="password">Your password</label>
                        <div class="password-container">
                            <input type="password" name="password" id="password" placeholder="Enter your password" required>
                            <span class="toggle-password" onclick="togglePassword()">👁️</span>
                        </div>
                    </p>
                    <p>
                        <input type="submit" id="submit" value="Create Account">
                    </p>
                </form>
            </main>
            <footer class="signup-footer">
                <p>Already have an account? <a href="login.php">Login</a></p>
            </footer>
        </div>
        <div class="circle c1"></div>
        <div class="circle c2"></div>
    </div>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.querySelector('.toggle-password');
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.textContent = '👁️‍🗨️';
            } else {
                passwordInput.type = 'password';
                toggleIcon.textContent = '👁️';
            }
        }
    </script>
</body>
</html>
