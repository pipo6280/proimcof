<?php
return [
    'must_be_array' => 'El método de validación de correo debe ser pasado como un array.',
    'invalid_address' => 'Dirección de correo no válida: %s',
    'attachment_missing' => 'No se ha podido localizar el siguiente fichero adjunto: %s',
    'attachment_unredable' => 'No se ha podido abrir el siguiente fichero adjunto: %s',
    'no_recipients' => 'Debe incluir receptores: Para=>CC=>o BCC',
    'send_failure_phpmail' => 'No se puede enviar el correo usando la función mail() de PHP.  Su servidor puede no estar configurado para usar este método de envio.',
    'send_failure_sendmail' => 'No se puede enviar el correo usando SendMail. Su servidor puede no estar configurado para usar este método de envio.',
    'send_failure_smtp' => 'No se puede enviar el correo usando SMTP PHP. Su servidor puede no estar configurado para usar este método de envio.',
    'sent' => 'Su mensaje ha sido enviado satisfactoriamente usando el siguiente protocolo: %s',
    'no_socket' => 'No se puede abrir un socket para Sendmail. Por favor revise la configuración.',
    'no_hostname' => 'No ha especificado un servidor SMTP',
    'smtp_error' => 'Los siguientes errores SMTP han sido encontrados: %s',
    'no_smtp_unpw' => 'Error: Debe asignar un usuario y contraseña para el servidor SMTP.',
    'failed_smtp_login' => 'Fallo enviando el comando AUTH LOGIN. Error: %s',
    'smtp_auth_un' => 'Fallo autentificando el usuario. Error: %s',
    'smtp_auth_pw' => 'Fallo usando la contraseña. Error: %s',
    'smtp_data_failure' => 'No se han podido enviar los datos: %s',
    'exit_status' => 'Código de estado de salida: %s'
];