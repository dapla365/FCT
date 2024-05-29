<?php include "components/user-data.php"; ?>
    <header>
        <div class="navbar" id="navbar">
            <div class="left">
                <a href="index.php"><img src="images/kano.png" alt="logo"></a>
            </div>
            <div class="middle">
                <a href="peluqueros.php"><i class="bi bi-scissors"></i>
                    <p>Peluqueros</p>
                </a>
                <a href="disponibles.php"><i class="bi bi-calendar2-week-fill"></i>
                    <p>Disponibles</p>
                </a>
                <a href="reservas.php"><i class="bi bi-calendar-check-fill"></i>
                    <p>Reservas</p>
                </a>

            </div>
            <div class="right">
                <?php 
                if($user_nivel > 5){      
                echo "            
                <a href='admin.php'><i class='bi bi-lock-fill'></i>
                    <p>Admin</p>
                </a>";
                }

                ?>
                <a href="perfil.php"><i class="bi bi-person-fill"></i>
                    <p>Perfil</p>
                </a>
                <a href="logout.php"><i class="bi bi-door-open-fill"></i>
                    <p>Logout</p>
                </a>
            </div>
            <a href="javascript:void(0);" title="Menu" style="font-size:18px;" class="icon"
                onclick="myFunction()">&#9776;</a>
        </div>
    </header>
