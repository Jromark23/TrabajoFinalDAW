<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Congrexia - <?= $titulo; ?></title>
	<link rel="icon" href="/public/build/img/favicon.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;700;900&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/public/build/css/app.css">
</head>

<body class="dashboard">
        <?php 
            include_once __DIR__ .'/templates/admin-header.php';
        ?>
        <div class="dashboard__grid">
            <?php
                include_once __DIR__ .'/templates/admin-sidebar.php';  
            ?>

            <main class="dashboard__contenido">
                <?php 
                    echo $contenido; 
                ?> 
            </main>
        </div>


	<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.min.js" integrity="sha512-L0Shl7nXXzIlBSUUPpxrokqq4ojqgZFQczTYlGjzONGTDAcLremjwaWv5A+EDLnxhQzY5xUZPWLOLqYRkY0Cbw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="/public/build/js/main.min.js" defer></script>
</body>
</html>