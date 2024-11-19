<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="/styles.css">
    <link rel="stylesheet" href="/public/css/libs/select2/select2.min.css">
    <script src="/public/js/libs/jquery/jquery.min.js"></script>
    <script src="/public/js/libs/select2/select2.min.js"></script>
</head>

<body>
    <?php require_once 'app/views/templates/header.php'; ?>
    <main>
        <?php if (is_string($methodName) && method_exists($controller, $methodName)) {
            $controller->$methodName();
        } else {
            require_once 'app/views/error.php';
        } ?>
    </main>
    <?php require_once 'app/views/templates/footer.php'; ?>
</body>

</html>