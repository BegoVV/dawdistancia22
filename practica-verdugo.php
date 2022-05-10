<?php
/**
 * Archivo pratica-verdugo.php
 *
 * @
 * @author Bego Verdugo <bvvdev@gmail.com>
 * @versión 1.0
 */


/**
 * Función - Comprueba si es posible convertir la hora en formato hh:mm a minutos
 * @param $hora Hora en formato hh:mm
 * @return false si no se pudo hacer la conversión y true en caso contrario.
 */
function convertirHoraAMinutos ($hora)
{    
    list($hora,$minutos)=explode(":",$hora);
    return ($hora>=0 && $hora<24 && $minutos>=0 && $minutos<60) ? $hora*60+$minutos : false;
}



/**
 *Función - Realiza la eliminación de una reserva.
 * @param PDO $pdo Conexión válida a la base de datos.
 * @param array $datosReserva array con los datos de reserva a eliminar ['zona_id', 'fecha_actual', 'inicio_actual']
 *              Nota: la fecha debe ir en formato aaaa-mm-dd
 * @return mixed - false si no se pudo realizar la operación
 *                          - un número entero con el número de registros eliminados en caso de que si se pudiera hacer la  operación.
 */
function eliminarReserva(PDO $pdo, array $datosReserva)
{
    $retorno = false;
    $campos=['zona_id', 'fecha_actual', 'inicio_actual'];
    if (!array_diff($campos,array_keys($datosReserva))) {
       
        $query="DELETE FROM reservas WHERE zona_id=:zona_id AND fecha=:fecha_actual AND inicio=:inicio_actual";
        try{
            $stmt=$pdo->prepare($query);
            if ($stmt->execute($datosReserva))
            {
                $retorno=$stmt->rowCount();        
            }            
        }
        catch (PDOException $ex)
        {
            //Nothing to do here
        }      
    }
}
?>
