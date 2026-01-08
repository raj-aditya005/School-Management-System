<?php
session_start();
include "config/db.php";

if (isset($_POST['login'])) {
  $username = $_POST['username'];
  $password = $_POST['password'];

  $query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
  $result = mysqli_query($conn, $query);

  if (mysqli_num_rows($result) == 1) {
    $user = mysqli_fetch_assoc($result);
    $_SESSION['role'] = $user['role'];
    $_SESSION['username'] = $user['username']; // ✅ ADD THIS
    $_SESSION['user_id'] = $user['id']; // (recommended)

    header("Location: dashboard.php");
  } else {
    echo "<script>alert('Invalid login');</script>";
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>School Management System</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- UI / Animation CSS -->
  <style>
    body {
  font-family: 'Segoe UI', system-ui, sans-serif;

  background: linear-gradient(125deg, #2b2a45ff, #0a0b20ff);
}

    .login-wrapper {
      animation: fadeInUp 0.9s ease;
    }

    .login-card {
      border-radius: 16px;
      overflow: hidden;
      backdrop-filter: blur(6px);
      background: rgba(255, 255, 255, 0.95);
      max-width: 1000px;
    }

    .login-left {
      background: linear-gradient(135deg, #4338ca, #6366f1);
      color: #fff;
    }

    .login-left h3 {
      font-weight: 600;
      background: rgba(79, 70, 229, 0.85);
    }

    @keyframes fadeInUp {
      from {
        opacity: 0;
        transform: translateY(25px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .form-control:focus {
      box-shadow: 0 0 0 0.2rem rgba(99,102,241,.25);
      border-color: #6366f1;
    }

    .btn-primary {
      background-color: #4f46e5;
      border: none;
    }

    .btn-primary:hover {
      background-color: #4338ca;  
    }
    .login-logo {
  width: 90px;
  height: auto;
}

.logo-animate {
  animation: logoDrop 1s ease forwards;
}

@keyframes logoDrop {
  from {
    opacity: 0;
    transform: translateY(-25px) scale(0.9);
  }
  to {
    opacity: 1;
    transform: translateY(0) scale(1);
  }
}
.login-logo:hover {
  filter: drop-shadow(0 0 10px rgba(79,70,229,0.6));
  transition: 0.3s;
}
/* 🌌 STAR BACKGROUND */
.stars {
  position: fixed;
  inset: 0;
  z-index: 0;
  pointer-events: none;
  overflow: hidden;
}

.stars span {
  position: absolute;
  width: 3px;
  height: 3px;
  background: rgba(255, 255, 255, 0.8);
  border-radius: 50%;
  animation: twinkle ease-in-out infinite;
}

/* twinkling animation */
@keyframes twinkle {
  0%, 100% { opacity: 0.2; }
  50% { opacity: 1; }
}

/* ensure login card stays above */
.login-card {
  position: relative;
  z-index: 5;
}

/* ✨ Sparkle container */
#sparkle-container {
  position: fixed;
  inset: 0;
  pointer-events: none;
  z-index: 2;
}

/* ✨ Single sparkle */
.sparkle {
  position: absolute;
  width: 16px;
  height: 16px;
  background: radial-gradient(circle, #8451f3ff, transparent 70%);
  border-radius: 50%;
  opacity: 1;
  animation: sparkleFade 1s ease-out forwards;
}

/* ✨ Sparkle animation */
@keyframes sparkleFade {
  0% {
    transform: scale(1.5);
    opacity: 1.5;
  }
  100% {
    transform: scale(3);
    opacity: 0;
  }
}

/* Keep login card above sparkles */
.login-card {
  position: relative;
  z-index: 5;
}

  </style>
</head>

<body>

<div class="stars"></div>
<div id="sparkle-container"></div>

<div class="container">
  <div class="row justify-content-center align-items-center vh-100 login-wrapper">

    <div class="col-xl-8 col-lg-9 col-md-10">
      <div class="card shadow-lg login-card mx-auto">
        <div class="row g-0">

          <!-- LEFT INFO PANEL -->
          <div class="col-md-6 d-none d-md-flex flex-column justify-content-center align-items-center login-left p-5">
            <div class="text-center mb-4 logo-animate">
               <img src="assets/img-2.png"
                    alt="School Logo"
                    class="login-logo">
            </div>

            <h3>School Management System</h3>
            <p class="text-center mt-3">
              Manage students, teachers, attendance & fees<br>
              from one secure platform.
            </p>
            <ul class="list-unstyled mt-3">
              <li>✔ Student & Teacher Records</li>
              <li>✔ Attendance & Reports</li>
              <li>✔ Fees Management</li>
              <li>✔ Role Based Access</li>
            </ul>
          </div>

          <!-- RIGHT LOGIN FORM -->
          <div class="col-md-6 px-5 py-5">
            <h3 class="text-center mb-4 fw-semibold">Login</h3>


            <!-- 🔐 ORIGINAL FORM (UNCHANGED LOGIC) -->
            <form method="POST">
              <input type="text"
                     name="username"
                     class="form-control mb-4"
                     placeholder="Username"
                     required>

              <input type="password"
                     name="password"
                     class="form-control mb-4"
                     placeholder="Password"
                     required>

              <button name="login" class="btn btn-primary w-100 py-3 fs-5">
                Login
              </button>
            </form>

            <div class="text-center text-muted mt-3 small">
              Secure Login • Admin / Teacher / Student
            </div>

          </div>

        </div>
      </div>
    </div>

  </div>
</div>
<script>
const starContainer = document.querySelector('.stars');

for (let i = 0; i < 80; i++) {
  const star = document.createElement('span');

  const size = Math.random() * 2 + 1;
  star.style.width = size + 'px';
  star.style.height = size + 'px';

  star.style.top = Math.random() * 100 + '%';
  star.style.left = Math.random() * 100 + '%';

  const duration = Math.random() * 3 + 2;
  star.style.animationDuration = duration + 's';

  star.style.animationDelay = Math.random() * 5 + 's';

  starContainer.appendChild(star);
}
</script>
<script>
const sparkleContainer = document.getElementById("sparkle-container");

document.addEventListener("mousemove", (e) => {
  // limit sparkle frequency
  if (Math.random() > 0.85) {
    const sparkle = document.createElement("div");
    sparkle.className = "sparkle";

    sparkle.style.left = e.clientX + "px";
    sparkle.style.top = e.clientY + "px";

    sparkleContainer.appendChild(sparkle);

    // remove sparkle after animation
    setTimeout(() => {
      sparkle.remove();
    }, 800);
  }
});
</script>
<?php include "assets/ai-widget.php"; ?>

</body>
</html>
