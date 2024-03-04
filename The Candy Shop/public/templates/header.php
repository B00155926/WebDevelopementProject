<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>The Candy Shop</title>
    <link rel="stylesheet" href="../css/CandyShop.css"/>

    <script>
        function stickyMenu () {
            var sticky=document.getElementById("sticky");
            if(window.pageXOffset > 220) {
                sticky.classList.add("sticky");
            }
            else {
                sticky.classList.add("sticky");
            }
        }

        window.onscroll = function () {
            stickyMenu();
        }
    </script>
</head>

<body>
