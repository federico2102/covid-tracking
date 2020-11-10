# yoEstuveAhi-laravel
* Permitir que los usuarios puedan registrar locaciones. (LISTO)
    * Por cada locación, el sistema deberá saber:
        * Nombre (LISTO)
        * Capacidad máxima (LISTO)
        * Geoposición (Latitud y Longitud) (LISTO)
        * Generar un QR que identifique a la locación de manera unívoca (LISTO)
* Permitir que los usuarios puedan realizar checkin y checout:
    * Indicar que han ingresado a una locación, leyendo el código QR de la misma. (LISTO)
        * Una persona sólo podrá estar en una locación a la vez (LISTO)
    * Indicar que han salido de una locación, leyendo el código QR de la misma. (LISTO) 
    * Consultar en todo momento el estado de una locación en cuanto a su capacidad máxima y cantidad de personas dentro. (LISTO)
* Permitir que los usuarios puedan informar su contagio y su alta:
    * Los usuarios podrán informar que se han contagiado de CODIV, informando la fecha del diagnóstico. (LISTO)
    * Los usuarios podrán informar que se han sido dados de alta, informando la fecha del resultado. (LISTO)
    * Los usuarios que estén en estado contagiado, no podrán ingresar a ninguna locación. (LISTO)
* Riesgo de contagio
    * El sistema deberá notificar mediante un mensaje en la pantalla y mediante correo electrónico a todos aquellos 
    usuarios que hayan estado compartiendo presencia dentro de una locación en algún rango horario 
    (se puede asumir un bloque de 15 o 30 minutos como mínimo). (LISTO)
    * El mensaje en pantalla no necesariamente se requiere que sea instantáneo: podría aparecer recién en el próximo ingreso del usuario. (LISTO)
* Perfil administrador (LISTO)
    * El rol administrador podrá visualizar en un mapa todas las locaciones registradas junto con su información de 
    estado (capacidad versus concurrencia) (LISTO)
    * También podrá visualizar un dashboard con las estadísticas de uso del sistema (cantidad de usuarios, cantidad de 
    locaciones, cantidad de usuarios infectados, cantidad de personas en riesgo de contagio). (LISTO)

####Importantes
* Que el propietario pueda asociarle a la locación, además de su nombre y descripción: Imágenes (POR AHORA SOLO SE PUEDE UNA IMAGEN)
* Que los usuarios con riesgo de contagio, reciban una advertencia antes de realizar un checkin. (RECIBEN MAIL)
* Que los usuarios con riesgo de contagio, puedan regresar a tu estado normal mediante la opción de “Testeo Negativo” 
(es decir, estando en riesgo de contagio, se hizo el test correspondiente y dio negativo). (LISTO)
* Pasado un tiempo configurable, los usuarios con riesgo de contagio automáticamente pasen a estado normal. (LISTO)

####Deseables
* Estando dentro de una locación, poder compartir por Whatapps el link para hacer Checkin. (LISTO)
* Incorporar notificaciones como alerta al recibir un contagio (instantáneas) (NO)
* Incorporar al perfil administrador, un mapa de calor que indique la cantidad de
contagios actuales e históricos, día x día. (NO)

####Falta arreglar (aca pueden ir escribiendo todo lo que falla o falta y no esta en el enunciado)
* Hacer un view presentable en el archivo cuerpoMail.blade.php
* Ver por que siempre hay que hacer doble loggin para ingresar
* Hacer que el boton check-in abra la camara o decidir como va a funcionar eso (Esta implementado, pero no funciona si no es Https)
* Modificar handler de excepciones para que si hay un error, el usuario vea la pantalla de "404 not found"

####Diagramas para la presentacion
*Diagrama de clases para los modelos (modelos mas importantes y sus funciones y como interactuan)
*Diagramas de flujo para eventos centrales (crear locacion, check-in, check-out, contagiar)
*MER (relacion entre las tablas)
*

####Decisiones de diseño
*Admin implementado con atributo "is_admin" en el usuario
*La tabla de victimas para saber con quienes se compartio mas de x tiempo
*Hashear los parametros que llegan al index de concurrio

####Puntos problematicos
*Google maps pide pagar para usar su api sin marca de agua
*Abrir la camara no funciona si no es https, y heroku cobra por eso
*Hay que hacer log in dos veces para poder ingresar (no llegamos a debuggear eso)
