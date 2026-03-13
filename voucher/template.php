																																																																		<style>
/* Estilo General */
.container {
    width: 180px;
    min-height: 120px; /* Asegura que haya suficiente espacio */
    padding: 0;
    margin: 0;
    border: 0.5px solid #C0C0C0;
    overflow: hidden;
    position: relative;
    float: left;
    -webkit-print-color-adjust: exact;
}

.qrcode {
    height: 60px;
    width: 60px;
}

/* Estilo para el perfil/plan (Ahora sobre el precio) */
.plan {
	width: 57px;
	height: auto;
    position: absolute;
    top: 17px; /* Justo arriba del precio */
    left: 2px;
    background: #fff;
    font-weight: bold;
    font-size: 18px;
    font-family: Calibri, sans-serif;
    color: #666;
    padding: 5px 5px;
    border-radius: 5px;
    text-align: center;
}

/* Estilo para el precio */
.precio {
    position: absolute;
    bottom: 8px; /* Ajustado para que esté debajo del perfil */
    left: 3px;
    background: #fff;
    width: auto;
    color: #777;
    font-weight: bold;
    font-family: Calibri, sans-serif;
    font-size: 33px;
    padding: 0px 1px 1px 0px;
    border-radius: 0 10px 10px 0;
}

/* Estilo para los datos del usuario */
.user-info {
    position: absolute;
    bottom: 1px; /* Más abajo para evitar solapamiento */
    right: 10px;
    color: #333;
    text-align: left;
    font-size: 12px;
}

/* Estilo para el texto de Usuario y Contraseña */
.label {
	font-size: 12px;
	margin-right: 6px; /* Ajusta el valor a tu gusto */
    font-weight:bold;
    color: #555;
}
.claves {
	font-size: 14px;
}

/* Línea separadora con puntos */
.dotted-line {
    border-bottom: 1px dotted #777;
    padding-bottom: 2px;
    margin-bottom: 2px;
}

/* Logo */
.logo {
    position: absolute;
    top: -6px;
    right: 3px;
    width: 98px;
	height: auto;
}
</style>

<div class="container">

    <!-- NUMERO DE PERFIL -->
    <div style="position: relative; width: 180px; height: 120px; border: 1px solid #ccc;">
        <div style="position: absolute; top: 2px; left: 3px; color: #333; font-size: 10px; font-weight: bold;">
            <small><?php echo "#$num"; ?></small>
        </div>
    </div>

    <!-- PERFIL/PLAN (Ahora sobre el precio) -->
    <div class="plan">
    <?php
    // Tipos de perfil
    $tipos = [
		"Plan_x3Horas" => '<img src="https://flagcdn.com/mx.svg" width="21px" alt="Bandera de México"> 3 HORAS',
		"Plan_x12Horas" => '<img src="https://flagcdn.com/mx.svg" width="21px" alt="Bandera de México"> 12 HORAS',
		"Z12-HORAS" => '<img src="https://flagcdn.com/mx.svg" width="21px" alt="Bandera de México"> 12 HORAS',
		"Plan_1Dias" => '<img src="https://flagcdn.com/mx.svg" width="21px" alt="Bandera de México"> 1 DIA',
        "3-HORAS" => '<img src="https://flagcdn.com/mx.svg" width="21px" alt="Bandera de México"> 3 HORAS',
		"z3-HORAS" => '<img src="https://flagcdn.com/mx.svg" width="21px" alt="Bandera de México"> 3 HORAS',
		"4-HORAS" => '<img src="https://flagcdn.com/mx.svg" width="21px" alt="Bandera de México"> 4 HORAS',
		"4-HORAS-1MB" => '<img src="https://flagcdn.com/mx.svg" width="21px" alt="Bandera de México"> 4 HORAS',
        "8-HORAS" => '<img src="https://flagcdn.com/mx.svg" width="21px" alt="Bandera de México"> 8 HORAS',
		"10-HORAS" => '<img src="https://flagcdn.com/mx.svg" width="21px" alt="Bandera de México"> 10 HORAS',
        "1-DIA" => '<img src="https://flagcdn.com/mx.svg" width="21px" alt="Bandera de México"> 1 DIA',
		"Plan_3Dias" => '<img src="https://flagcdn.com/mx.svg" width="21px" alt="Bandera de México"> 3 DIAS',
		"Z1-DIA" => '<img src="https://flagcdn.com/mx.svg" width="21px" alt="Bandera de México"> 1 DIA',
        "1-SEMANA" => '<img src="https://flagcdn.com/mx.svg" width="21px" alt="Bandera de México"> 1 SEMANA',
		"Plan_7Dias" => '<img src="https://flagcdn.com/mx.svg" width="21px" alt="Bandera de México"> 1 SEMANA',
		"Plan_30Dias" => '<img src="https://flagcdn.com/mx.svg" width="21px" alt="Bandera de México"> 1 MES',
    ];

    // Mostrar el tipo de perfil
    echo isset($tipos[$profile]) ? $tipos[$profile] : strtoupper($profile);
    ?>
</div>

    <!-- PRECIO -->
    <div class="precio">
        <?php
        // Precios definidos
        $precios = [
			"Plan_x3Horas" => "$5",
			"Plan_x12Horas" => "$10",
            "3-HORAS" => "$5",
			"4-HORAS" => "$5",
			"4-HORAS-1MB" => "$5",
            "8-HORAS" => "$10",
			"10-HORAS" => "$10",
            "1-DIA" => "$15",
			"Z1-DIA" => "$15",
			"Plan_1Dias" => "$12",
			"Plan_3Dias" => "$30",
			"1-SEMANA" => "$65",
			"Plan_7Dias" => "$60",
			"Plan_30Dias" => "",
        ];

        // Mostrar precio según el perfil
        echo isset($precios[$profile]) ? $precios[$profile] : '';
        ?>
    </div>

    <!-- DATOS DEL USUARIO Y CONTRASEÑA -->
    <div class="user-info">
        <?php if ($usermode == "up"): ?>
            <!-- Usuario con línea punteada debajo -->
            <div class="dotted-line"><span class="label">Usuario:</span><span class="claves"><?php echo $username; ?></span></div>
            
            <!-- Contraseña con línea punteada debajo -->
            <div class="dotted-line"><span class="label">Contraseña:</span><span class="claves"><?php echo $password; ?></span></div>
        <?php endif; ?>
	</div>

    <!-- QR CODE (Si está habilitado) -->
    <?php if ($qr == "yes"): ?>
        <div style="position: absolute; bottom: -4px; left: 125px; width: 60px;">
            <?php echo $qrcode; ?>
        </div>
    <?php endif; ?>

    <!-- LOGO -->
    <img class="logo" src="<?php echo $logo; ?>" alt="logo">

</div>	        	        	        	        	        	        	        	        	        	        	        	        	        	        	        	        	        	        	        	        	        	        	        	        	        	        	        	        	        	        	        	        	        	        	        	        	        	        	        	        	        	        	        	        	        	        	        	        	        	        	        	        	        	        	        	        	        	        	        	        	        	        	        	        	        	        	        	        	        	        	        	        	        	        	        	        	        	        	        	        	        	        	        	        	        	        	        	        	        	        	        	        	        	        	        	        	        	        	        	        	        	        	        	        	        	        	        	        	        	        	        	        	        	        	        	        	        	        	        	        	        	        	        	        	        	        