<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>banglanews24/EN</title>
</head>
<body>
<div class="container">
    <span class="welcome">banglanews24/EN</span>
</div>

<style type="text/css">
.container .welcome {
    font-family: sans-serif;
    display: block;
}

.container {
    text-align: center;
    position: absolute;
    left: 50%;
    top: 50%;
    transform: translate(
        -50%,
        -50%
    );
    width: 100%;
}

.welcome {
    font-size: 60px;
    font-weight: 700;
    color: #fff;
    letter-spacing: 8px;
    margin-bottom: 20px;
    background: #000;
    position: relative;
    animation: text 3s 1;
    padding: 15px 0 10px 0;
}


@keyframes text {
  0% {
    color: #000;
    margin-bottom: -40px;
  }

  30% {
    letter-spacing: 25px;
    margin-bottom: -40px;
  }

  85% {
    letter-spacing: 8px;
    margin-bottom: -40px;
  }
}

</style>
</body>
</html>