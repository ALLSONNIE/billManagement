<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gastos</title>
    <link rel="stylesheet" href="./style.css">
</head>
<body class="background">
    <h1 class="titles-clr">Gastos</h1>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <div class="form-group">
            <label for="descripcion" class="titles-clr">Descripción:</label>
            <div class="">
                <input type="text" name="descripcion" id="descripcion" class="form-control box-style" placeholder="Descripción...">
            </div>
        </div>

        <div class="form-group">
            <label for="monto" class="titles-clr">Monto:</label>
            <div class="">
                <input type="text" name="monto" id="monto" class="form-control box-style" placeholder="Monto...">
            </div>
        </div>

        <div class="form-group">
            <input class="text-clr button-style" type="submit" name="submit" value="Agregar Gasto">
        </div>
    </form>

    <a href="eliminar.php" class="text-clr">Eliminar datos</a>

</body>
</html>

<?php

class Gasto {
    private $descripcion;
    private $monto;

    public function __construct($descripcion, $monto) {
        $this->descripcion = $descripcion;
        $this->monto = $monto;
    }

    public function getDescripcion() {
        return $this->descripcion;
    }

    public function getMonto() {
        return $this->monto;
    }
}

class RegistroGastos {
    private $listaGastos;

    public function __construct() {
        $this->listaGastos = array();
    }

    public function agregarGasto($descripcion, $monto) {
        $gasto = new Gasto($descripcion, $monto);
        $this->listaGastos[] = $gasto;
    }

    public function obtenerGastos() {
        return $this->listaGastos;
    }

    public function obtenerTotalGastos() {
        $total = 0;
        foreach ($this->listaGastos as $gasto) {
            $total += $gasto->getMonto();
        }
        return $total;
    }
}

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST["descripcion"]) && !empty($_POST["monto"])) {

        $descripcion = $_POST["descripcion"];
        $monto = $_POST["monto"];

        $registroGastos = isset($_SESSION['registroGastos']) ? $_SESSION['registroGastos'] : new RegistroGastos();

        $registroGastos->agregarGasto($descripcion, $monto);

        $_SESSION['registroGastos'] = $registroGastos;

        echo "<h2 class='titles-clr'>Lista de sus gastos:</h2>";
        echo "<ul class='text-clr'>";
        foreach ($registroGastos->obtenerGastos() as $gasto) {
            echo "<li class='text-clr'>" . $gasto->getDescripcion() . ": ₡" . $gasto->getMonto() . "</li>";
        }
        echo "</ul>";
        echo "<h2 class='titles-clr'>Total de sus gastos:</h2>";
        echo "<h2 class='text-clr'>₡" . $registroGastos->obtenerTotalGastos() . "</h2>";
    } else {
        echo "<p class='text-clr'>Ingrese los datos correspondientes</p>";
    }
}

?>
