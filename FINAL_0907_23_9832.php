<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="styles.css" rel="stylesheet"/>
</head>
<body>
    <?php
    function introduccion(){
        $miVariable = "Marco";
        echo "<h1>Hola" . $miVariable . "</h1>";
    
        $val1 = 10;
        $val2 = 0;
        $suma = $val1 + $val2;
        $resta = $val1 - $val2;
    
        if($suma > 10){
            echo "La suma es mayor a 10 es " . $suma;
    
        }
        else{
            echo "La suma es menor a 10 es " . $suma;
        }
        for($contador = 1 ; $contador <= 10 ; $contador ++){
            echo "contador " .$contador . "<br/>";
    
        }
    } 
 
    //introduccion();

    $pdo_options[PDO::ATTR_ERRMODE]=PDO::ERRMODE_EXCEPTION;
    $conexion = new PDO('mysql:host=localhost;dbname=final_0907_23_9832', 'root', '', $pdo_options);
    
    if(isset($_POST["accion"])) {
  if ($_POST['accion'] == "Crear"){
       $insert = $conexion->prepare("INSERT INTO producto (codigo,nombre,precio,
       existencia) VALUES (:codigo,:nombre,:precio,:existencia)");
       $insert->bindValue('codigo', $_POST['codigo']);
       $insert->bindValue('nombre', $_POST['nombre']);
       $insert->bindValue('precio', $_POST['precio']);
       $insert->bindValue('existencia', $_POST['existencia']);
       $insert->execute();
    }

    if ($_POST['accion'] == "Editado"){
        $update = $conexion->prepare("UPDATE producto SET nombre=:nombre, precio=:precio, 
        existencia=:existencia WHERE codigo=:codigo"); 
        $update->bindValue('codigo', $_POST['codigo']);
        $update->bindValue('nombre', $_POST['nombre']);
        $update->bindValue('precio', $_POST['precio']);
        $update->bindValue('existencia', $_POST['existencia']);
        $update->execute();
        header("Refresh: 0");
     }
}



    $select = $conexion->query("SELECT codigo, nombre, precio, existencia FROM producto")
    ?>


    <?php if (isset($_POST["accion"] ) && $_POST["accion"] == "Editar" ){ ?>

<form  method="POST">
        <input type="text" name="codigo" value="<?php echo $_POST ["codigo"] ?> "placeholder="Ingrese el codigo">
        <br/>
        <input type="text" name="nombre" placeholder="Ingrese el nombre">
        <br/>
        <input type="text" name="precio" placeholder="Ingrese el precio">
        <br/>
        <input type="text" name="existencia" placeholder="Ingrese la existencia">
        <br/>
        <input type="hidden" name="accion" value="Editado">
        <button type="submit" >Guardar</button>

</form>
<?php } else {?>

    <form  method="POST">
        <input type="text" name="codigo" placeholder="Ingrese el codigo">
        <br/>
        <input type="text" name="nombre" placeholder="Ingrese el nombre">
        <br/>
        <input type="text" name="precio" placeholder="Ingrese el precio">
        <br/>
        <input type="text" name="existencia" placeholder="Ingrese la existencia">
        <br/>
        <input type="hidden" name="accion" value="crear">
        <button type="submit" >Crear</button>

</form>


<?php } ?>

<table border="1">
        <thead>
            <tr>

                <th>codigo</th>
                <th>Nombre</th>
                <th>precio</th>
                <th>existencia</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($select->fetchAll() as $alumno) { ?>
                <tr>
                    <td> <?php  echo $alumno ["codigo"] ?> </td>
                    <td> <?php  echo $alumno ["nombre"] ?> </td>
                    <td> <?php  echo $alumno ["precio"] ?> </td>
                    <td> <?php  echo $alumno ["existencia"] ?> </td>
                    <td> 
                        <form  method="POST">

                            <button type="submit">Editar </button>
                            <input type="hidden" name ="accion" value="Editar"/> 
                             <input type="hidden"  name = "codigo" value="<?php echo $alumno["codigo"] ?>"/>

                                    
                        </form>
            </td>
            </tr>        

                <?php } ?>

      </tbody>



    </table>
    <script src= "script.js" ></script>
    </body>

</html>