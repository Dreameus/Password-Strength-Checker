<?php
// Password validation logic
function checkPasswordStrength($password) {
    $strength = 0;
    $feedback = [];
    
    // Check password length
    $length = strlen($password);
    if ($length >= 12) {
        $strength += 3;
    } elseif ($length >= 8) {
        $strength += 2;
        $feedback[] = "Consider making your password longer (at least 12 characters)";
    } else {
        $feedback[] = "Password is too short (minimum 8 characters)";
    }
    
    // Check for uppercase letters
    if (preg_match('/[A-Z]/', $password)) {
        $strength += 1;
    } else {
        $feedback[] = "Add uppercase letters (A-Z)";
    }
    
    // Check for lowercase letters
    if (preg_match('/[a-z]/', $password)) {
        $strength += 1;
    } else {
        $feedback[] = "Add lowercase letters (a-z)";
    }
    
    // Check for numbers
    if (preg_match('/[0-9]/', $password)) {
        $strength += 1;
    } else {
        $feedback[] = "Add numbers (0-9)";
    }
    
    // Check for special characters
    if (preg_match('/[^A-Za-z0-9]/', $password)) {
        $strength += 1;
    } else {
        $feedback[] = "Add special characters (!@#$%^&*)";
    }
    
    // Determine strength level
    $levels = [
        0 => ["name" => "Very Weak", "color" => "danger", "width" => 20],
        1 => ["name" => "Weak", "color" => "danger", "width" => 30],
        2 => ["name" => "Fair", "color" => "warning", "width" => 50],
        3 => ["name" => "Good", "color" => "info", "width" => 70],
        4 => ["name" => "Strong", "color" => "success", "width" => 90],
        5 => ["name" => "Very Strong", "color" => "success", "width" => 100],
        6 => ["name" => "Excellent", "color" => "success", "width" => 100],
    ];
    
    $level = min($strength, 6);
    $result = $levels[$level];
    
    // Add strength-specific feedback
    if ($level < 3) {
        $feedback[] = "Your password is too easy to guess. Follow the recommendations below.";
    } elseif ($level < 5) {
        $feedback[] = "Your password is acceptable but could be stronger.";
    }
    
    return [
        'strength' => $result,
        'feedback' => $feedback,
        'length' => $length
    ];
}

// Process form submission
$result = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['password'])) {
    $password = $_POST['password'];
    $result = checkPasswordStrength($password);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Strength Checker</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --gradient-start: #3494e6;
            --gradient-end: #ec6ead;
            --shadow: 0 8px 32px rgba(31, 38, 135, 0.2);
        }
        
        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            padding: 20px;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .card {
            border-radius: 20px;
            box-shadow: var(--shadow);
            border: none;
            overflow: hidden;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
        }
        
        .card-header {
            background: linear-gradient(135deg, var(--gradient-start), var(--gradient-end));
            color: white;
            font-weight: 700;
            font-size: 1.5rem;
            text-align: center;
            padding: 20px;
            border: none;
        }
        
        .card-body {
            padding: 30px;
        }
        
        .password-container {
            position: relative;
            margin-bottom: 25px;
        }
        
        .password-input {
            padding-right: 45px;
            height: 50px;
            border-radius: 10px;
            font-size: 1.1rem;
            border: 2px solid #e0e0e0;
        }
        
        .password-input:focus {
            border-color: var(--gradient-start);
            box-shadow: 0 0 0 0.25rem rgba(52, 148, 230, 0.25);
        }
        
        .toggle-password {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #777;
            cursor: pointer;
        }
        
        .strength-meter {
            height: 10px;
            border-radius: 5px;
            margin: 20px 0;
            background-color: #e9ecef;
            overflow: hidden;
        }
        
        .strength-meter-fill {
            height: 100%;
            border-radius: 5px;
            transition: width 0.5s ease, background-color 0.5s ease;
        }
        
        .strength-label {
            font-weight: 600;
            font-size: 1.2rem;
            text-align: center;
            margin-top: 10px;
        }
        
        .recommendations {
            background-color: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
            margin-top: 25px;
            border-left: 4px solid var(--gradient-start);
        }
        
        .recommendations h5 {
            color: #495057;
            margin-bottom: 15px;
        }
        
        .list-group-item {
            border: none;
            padding: 8px 15px;
            color: #6c757d;
        }
        
        .list-group-item i {
            width: 25px;
            color: var(--gradient-start);
        }
        
        .btn-check {
            background: linear-gradient(135deg, var(--gradient-start), var(--gradient-end));
            border: none;
            border-radius: 10px;
            padding: 12px 25px;
            font-weight: 600;
            font-size: 1.1rem;
            transition: transform 0.3s, box-shadow 0.3s;
            width: 100%;
        }
        
        .btn-check:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 15px rgba(52, 148, 230, 0.4);
        }
        
        .password-stats {
            display: flex;
            justify-content: space-between;
            margin-top: 15px;
            font-size: 0.9rem;
            color: #6c757d;
        }
        
        .stat-item {
            text-align: center;
            padding: 10px;
            background: rgba(233, 236, 239, 0.5);
            border-radius: 8px;
            flex: 1;
            margin: 0 5px;
        }
        
        .stat-value {
            font-weight: 700;
            font-size: 1.2rem;
            color: var(--gradient-start);
        }
        
        .footer {
            text-align: center;
            margin-top: 30px;
            color: #6c757d;
            font-size: 0.9rem;
        }
        
        .result-container {
            animation: fadeIn 0.5s ease;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .password-criteria {
            margin-top: 20px;
        }
        
        .criteria-item {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }
        
        .criteria-icon {
            width: 24px;
            height: 24px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 10px;
            background-color: #e9ecef;
        }
        
        .criteria-valid {
            background-color: #d1e7dd;
            color: #0f5132;
        }
        
        .criteria-invalid {
            background-color: #f8d7da;
            color: #842029;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-xl-6">
                <div class="card">
                    <div class="card-header">
                        <i class="fas fa-lock me-2"></i>Password Strength Checker
                    </div>
                    <div class="card-body">
                        <form method="POST" action="index.php">
                            <div class="password-container">
                                <input 
                                    type="password" 
                                    class="form-control password-input" 
                                    id="password" 
                                    name="password"
                                    placeholder="Enter your password to check its strength" 
                                    required
                                    autocomplete="off"
                                    autofocus
                                >
                                <button type="button" class="toggle-password" id="togglePassword">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            
                            <button type="submit" class="btn btn-primary btn-check">
                                <i class="fas fa-shield-alt me-2"></i>Check Password Strength
                            </button>
                            
                            <div class="password-stats">
                                <div class="stat-item">
                                    <div class="stat-label">Length</div>
                                    <div class="stat-value" id="lengthStat"><?= isset($result) ? $result['length'] : '0' ?></div>
                                </div>
                                <div class="stat-item">
                                    <div class="stat-label">Strength</div>
                                    <div class="stat-value" id="strengthStat"><?= isset($result) ? $result['strength']['name'] : 'N/A' ?></div>
                                </div>
                            </div>
                        </form>
                        
                        <?php if (isset($result)): ?>
                        <div class="result-container mt-4">
                            <h5 class="mb-3">Password Strength Analysis</h5>
                            
                            <div class="strength-meter">
                                <div 
                                    class="strength-meter-fill" 
                                    style="
                                        width: <?= $result['strength']['width'] ?>%;
                                        background-color: var(--bs-<?= $result['strength']['color'] ?>);
                                    "
                                ></div>
                            </div>
                            <div class="strength-label text-<?= $result['strength']['color'] ?>">
                                <?= $result['strength']['name'] ?> Password
                            </div>
                            
                            <div class="password-criteria mt-4">
                                <h6>Password Criteria:</h6>
                                <div class="criteria-item">
                                    <div class="criteria-icon <?= $result['length'] >= 8 ? 'criteria-valid' : 'criteria-invalid' ?>">
                                        <i class="fas <?= $result['length'] >= 8 ? 'fa-check' : 'fa-times' ?>"></i>
                                    </div>
                                    <span>Minimum 8 characters (<?= $result['length'] ?>/8)</span>
                                </div>
                                <div class="criteria-item">
                                    <div class="criteria-icon <?= preg_match('/[A-Z]/', $_POST['password']) ? 'criteria-valid' : 'criteria-invalid' ?>">
                                        <i class="fas <?= preg_match('/[A-Z]/', $_POST['password']) ? 'fa-check' : 'fa-times' ?>"></i>
                                    </div>
                                    <span>Contains uppercase letters</span>
                                </div>
                                <div class="criteria-item">
                                    <div class="criteria-icon <?= preg_match('/[a-z]/', $_POST['password']) ? 'criteria-valid' : 'criteria-invalid' ?>">
                                        <i class="fas <?= preg_match('/[a-z]/', $_POST['password']) ? 'fa-check' : 'fa-times' ?>"></i>
                                    </div>
                                    <span>Contains lowercase letters</span>
                                </div>
                                <div class="criteria-item">
                                    <div class="criteria-icon <?= preg_match('/[0-9]/', $_POST['password']) ? 'criteria-valid' : 'criteria-invalid' ?>">
                                        <i class="fas <?= preg_match('/[0-9]/', $_POST['password']) ? 'fa-check' : 'fa-times' ?>"></i>
                                    </div>
                                    <span>Contains numbers</span>
                                </div>
                                <div class="criteria-item">
                                    <div class="criteria-icon <?= preg_match('/[^A-Za-z0-9]/', $_POST['password']) ? 'criteria-valid' : 'criteria-invalid' ?>">
                                        <i class="fas <?= preg_match('/[^A-Za-z0-9]/', $_POST['password']) ? 'fa-check' : 'fa-times' ?>"></i>
                                    </div>
                                    <span>Contains special characters</span>
                                </div>
                            </div>
                            
                            <?php if (!empty($result['feedback'])): ?>
                            <div class="recommendations mt-4">
                                <h5><i class="fas fa-lightbulb me-2"></i>Recommendations to Improve</h5>
                                <ul class="list-group">
                                    <?php foreach ($result['feedback'] as $feedback): ?>
                                    <li class="list-group-item">
                                        <i class="fas fa-chevron-circle-right me-2"></i><?= $feedback ?>
                                    </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                            <?php endif; ?>
                        </div>
                        <?php else: ?>
                        <div class="text-center mt-5">
                            <i class="fas fa-lock-open fa-3x text-muted mb-3"></i>
                            <p class="text-muted">Enter a password to check its strength and get recommendations</p>
                        </div>
                        <?php endif; ?>
                        
                        <div class="footer mt-4">
                            <p class="mb-0">Created with <i class="fas fa-heart text-danger"></i> | Password Strength Checker</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Toggle password visibility
        document.getElementById('togglePassword').addEventListener('click', function() {
            const passwordInput = document.getElementById('password');
            const icon = this.querySelector('i');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                icon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        });
        
        // Update length counter in real-time
        document.getElementById('password').addEventListener('input', function() {
            document.getElementById('lengthStat').textContent = this.value.length;
        });
    </script>
</body>
</html>
