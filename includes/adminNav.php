<?php
    if(!isset($_SESSION)) {
        session_start();
    }
?>
<header>
    <div class="navbar">
        <div class="logo">
            <a href="./index"><img src="../assets/img/DefaultLogo.png" alt=""></a>
        </div>
        <div id="menu" class="menu">
            <ion-icon id="menu-icon" name="menu"></ion-icon>
        </div>
        <nav id="nav">  
            <ul>
                <li><a href="./index" <?php if($currentPage === "home") { echo "class='active-page'"; } ?>>Products</a></li>
                <li><a href="./orders"  <?php if($currentPage === "orders") { echo "class='active-page'"; } ?>>Orders</a></li>
                <li><a href="./action?logout=true">Logout</a></li>
            </ul>
        </nav>
    </div>
</header>

<script>
    const menu = document.getElementById("menu");
    const nav = document.getElementById("nav");
    const icon = document.getElementById("menu-icon");
    var clicked = false;

    menu.addEventListener('click', () => {
        if (clicked) {
            nav.classList.remove("nav");
            icon.setAttribute("name", "menu");
            clicked = false;
        } else {
            nav.classList.add("nav");
            icon.setAttribute("name", "close");
            clicked = true;
        }
    });
    
</script>