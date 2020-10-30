# yoEstuveAhi-laravel
 Permitir que los usuarios puedan registrar locaciones. (LISTO)
    o Por cada locación, el sistema deberá saber:
         Nombre (LISTO)
         Capacidad máxima (LISTO)
         Geoposición (Latitud y Longitud) (LISTO)
         Generar un QR que identifique a la locación de manera unívoca (LISTO)
 Permitir que los usuarios puedan realizar checkin y checout:
    o Indicar que han ingresado a una locación, leyendo el código QR de la misma. (LISTO)
         Una persona sólo podrá estar en una locación a la vez (LISTO)
    o Indicar que han salido de una locación, leyendo el código QR de la misma. (LISTO) 
    o Consultar en todo momento el estado de una locación en cuanto a su capacidad máxima y cantidad de personas dentro. (LISTO)
 Permitir que los usuarios puedan informar su contagio y su alta:
    o Los usuarios podrán informar que se han contagiado de CODIV, informando la fecha del diagnóstico. (FALTA INFORMAR FECHA)
    o Los usuarios podrán informar que se han sido dados de alta, informando la fecha del resultado. (FALTA INFORMAR FECHA)
    o Los usuarios que estén en estado contagiado, no podrán ingresar a ninguna locación. (LISTO)
 Riesgo de contagio
    o El sistema deberá notificar mediante un mensaje en la pantalla y mediante correo electrónico a todos aquellos 
    usuarios que hayan estado compartiendo presencia dentro de una locación en algún rango horario 
    (se puede asumir un bloque de 15 o 30 minutos como mínimo). (FALTA CONFIGURAR QUE HAYAN ESTADO 15 O 30 MINUTOS. POR AHORA CON QUE HAYAN ESTADO UN MINUTO YA SE INFORMA)
    o El mensaje en pantalla no necesariamente se requiere que sea instantáneo: podría aparecer recién en el próximo ingreso del usuario. (LISTO)
 Perfil administrador (FALTA IMPLEMENTAR EL ROL)
    o El rol administrador podrá visualizar en un mapa todas las locaciones registradas junto con su información de 
    estado (capacidad versus concurrencia) (LISTO)
    o También podrá visualizar un dashboard con las estadísticas de uso del sistema (cantidad de usuarios, cantidad de 
    locaciones, cantidad de usuarios infectados, cantidad de personas en riesgo de contagio). (FALTA IMPLEMENTAR)

Importantes
 Que el propietario pueda asociarle a la locación, además de su nombre y descripción: Imágenes (POR AHORA SOLO SE PUEDE UNA IMAGEN)
 Que los usuarios con riesgo de contagio, reciban una advertencia antes de realizar un checkin. (RECIBEN MAIL)
 Que los usuarios con riesgo de contagio, puedan regresar a tu estado normal mediante la opción de “Testeo Negativo” 
(es decir, estando en riesgo de contagio, se hizo el test correspondiente y dio negativo). (FALTA PONER FECHA DE TESTEO)
 Pasado un tiempo configurable, los usuarios con riesgo de contagio automáticamente pasen a estado normal. (FALTA IMPLEMENTAR)

Deseables
 Estando dentro de una locación, poder compartir por Whatapps el link para hacer Checkin. (NO)
 Incorporar notificaciones como alerta al recibir un contagio (instantáneas) (NO)
 Incorporar al perfil administrador, un mapa de calor que indique la cantidad de
contagios actuales e históricos, día x día. (NO)

