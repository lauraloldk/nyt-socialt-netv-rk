<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Social Network Design</title>

        <style>
       

        #menu {
            background-color: #00cc99;
            padding: 10px;
            text-align: center;
        }

        #left-box {
            position: fixed;
            left: 0;
            top: 0;
            width: 20%;
            height: 100%;
            background-color: #2596be;
            padding: 50px;
        }

        #right-box {
            position: fixed;
            right: 0;
            top: 0;
            width: 20%;
            height: 100%;
            background-color: #2596be;
            padding: 20px;
        }

        #content {
            margin-left: 30%; /* Juster dette for at passe til #left-box bredde */
            margin-right: 30%; /* Juster dette for at passe til #right-box bredde */
            padding: 20px;
        }
    </style>
</head>
<body>
    
    <div id="menu">
        <a href="index.php">Home</a>
        <a href="onlinelist.php">Onlineliste</a>
    </div>
    <div id="left-box">
        <?php include 'login.php'; ?>
    </div>
    <div id="right-box">
        <?php include 'adminmenu.php'; ?>
    </div>
    <div id="content">
     
    </div>
</body>
</html>
