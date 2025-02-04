<?php 
  session_start();
  include_once "../php/config.php";
  if(!isset($_SESSION['unique_id'])){
    header("location: ../login.php");
  }
?>
<?php include_once "../header.php"; ?>


<!DOCTYPE html>
<html lang="en">
<head>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f5f5f5; /* Light gray background */
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 900px;
            margin: 20px auto;
            padding: 20px;
            background-color: #ffffff; /* White background */
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        h1 {
            margin-bottom: 20px;
            font-size: 24px;
            color: #e91e63; /* Bright pink */
            text-shadow: 1px 1px 3px rgba(255, 193, 7, 0.3); /* Yellow shadow */
        }

        .dropdown {
            margin-bottom: 15px;
        }

        .dropdown-btn {
            width: 100%;
            padding: 12px;
            background-color: #ffeb3b; /* Bright yellow */
            color: #333;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            text-align: left;
            font-size: 16px;
            transition: background-color 0.3s, transform 0.3s;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .dropdown-btn:hover {
            background-color: #fbc02d; /* Darker yellow */
            transform: translateY(-2px);
        }

        .dropdown-content {
            display: none;
            background-color: #fffde7; /* Light yellow */
            border: 1px solid #e91e63; /* Pink border */
            border-radius: 8px;
            padding: 10px;
            margin-top: 5px;
        }

        .dropdown-content a {
            display: block;
            padding: 10px;
            text-decoration: none;
            color: #333;
            transition: background-color 0.3s;
            border-radius: 4px;
        }

        .dropdown-content a:hover {
            background-color: #f8bbd0; /* Soft pink on hover */
        }

        .logout-container {
            text-align: center;
            margin-top: 30px;
        }

        .logout-btn {
            display: inline-block;
            padding: 12px 20px;
            background-color: #e91e63; /* Bright pink */
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            text-decoration: none;
            transition: background-color 0.3s, transform 0.3s;
        }

        .logout-btn:hover {
            background-color: #c2185b; /* Darker pink */
            transform: translateY(-2px);
        }

        @media (max-width: 768px) {
            .dropdown-btn {
                font-size: 14px;
                padding: 10px;
            }

            .dropdown-content a {
                font-size: 14px;
                padding: 8px;
            }
        }

        @media (max-width: 480px) {
            .container {
                padding: 15px;
            }

            .logout-btn {
                width: 100%;
                padding: 15px;
                font-size: 18px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <i class="fas fa-cogs"></i><h1>Settings</h1>
        <div class="dropdown">
            <button class="dropdown-btn">Account Settings</button>
            <div class="dropdown-content">
                <a href="update_profile.php"><i class="fas fa-user-edit"></i> Update Profile</a>
                <a href="security.php"><i class="fas fa-user-security"></i>Security</a>
                <a href="notifications.php"><i class="fas fa-user-notifications"></i>Notifications</a>
            </div>
        </div>
        <div class="dropdown">
            <button class="dropdown-btn">Privacy Settings</button>
            <div class="dropdown-content">
                <a href="privacy.php">Privacy Overview</a>
                <a href="data.php">Data Management</a>
            </div>
        </div>
        <div class="dropdown">
            <button class="dropdown-btn">Other Settings</button>
            <div class="dropdown-content">
                <a href="language.php">Language</a>
                <a href="theme.php">Theme</a>
            </div>
        </div>
    </div>
    
    <div class="container logout-container">
        <h1>Account Singout Here</h1>
        <a href="../php/logout.php" class="logout-btn"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </div>

    <script>
        document.querySelectorAll('.dropdown-btn').forEach(button => {
            button.addEventListener('click', () => {
                const dropdownContent = button.nextElementSibling;
                dropdownContent.style.display = dropdownContent.style.display === 'block' ? 'none' : 'block';
            });
        });
    </script>

</body>
</html>
