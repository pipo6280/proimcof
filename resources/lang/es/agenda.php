<?php
define('agenda_cliente_create_form', 'FORMULARIO - {0} cliente');
define('agenda_cliente_asignar_citas_form', 'FORMULARIO - AGENDAR CITA');
define('agenda_cliente_asignar_tratamientos_form', 'FORMULARIO - ASIGNAR TRATAMIENTO');
define('agenda_realizar_pago_form', 'FORMULARIO - PAGOS');

// cliente
define('agenda_primer_nombre', 'Primer nombre');
define('agenda_segundo_nombre', 'Segundo nombre');
define('agenda_primer_apellido', 'Primer apellido');
define('agenda_segundo_apellido', 'Segundo apellido');

define('agenda_tipo_documento', 'Tipo documento');
define('agenda_numero_documento', 'Número documento');
define('agenda_lugar_expedicion_documento', 'Lugar expedición');

define('agenda_cliente_antecedentes', 'Antecedentes Patológicos');
define('agenda_fecha_ultima_visita_odontologo', 'Ultima visita al odontologo');
define('agenda_observaciones', 'Observaciones');

define('agenda_fecha_nacimiento', 'Fecha de nacimiento');
define('agenda_estado_civil', 'Estado civil');
define('agenda_direcion', 'Dirección');
define('agenda_barrio', 'Barrio');
define('agenda_genero', 'Genero');
define('agenda_numero_fijo', 'Fijo');
define('agenda_movil', 'Celular');

define('agenda_foto_perfil', 'Rep_{0}.jpg');
define('agenda_cedula_duplicada', 'Error: Existe otra persona con la misma cédula');
define('agenda_cliente_registrado', 'Los datos del cliente <b>{0}</b> han sido registrado con éxito!');
define('agenda_cliente_modifica', 'Los datos del cliente <b>{0}</b> han sido modificado con éxito!');

// asignar citas
define('agenda_cliente', 'Cliente');
define('agenda_fecha_cita', 'Fecha de la cita');
define('agenda_hora_cita', 'Hora de la cita');
define('agenda_control_cita', 'Control');
define('agenda_control_select', 'El cliente ya se realizo este control, por favor elije el siguiente');

define('agenda_tipo_cita', 'Tipo cita');
define('agenda_control_ortodoncia', 'Control Ortodoncia');
define('agenda_odontologo_cita', 'Odontológo');
define('agenda_asignar_cita', 'Programar Cita');
define('agenda_search_cliente', 'Buscar cliente');
define('agenda_search_odontologo', 'Buscar Odontológo');
define('agenda_click_open_calender', 'Click abrir calendario');
define('agenda_click_open_reloj', 'Click abrir reloj');

// detalle cita
define('agenda_detalle_cita', 'Detalle cita {0}');
define('agenda_info_cliente', 'Datos del cliente');
define('agenda_info_cita', 'Datos de la cita');
define('agenda_info', 'Información');
define('agenda_name_cliente', 'Nombres:');
define('agenda_identificacion_cliente', 'Identificación:');
define('agenda_genero_cliente', 'Género:');
define('agenda_direccion_cliente', 'Dirección:');
define('agenda_contacto_cliente', 'Contacto:');
define('agenda_visita_fecha_cliente', 'Visita al odontólogo:');
define('agenda_observaciones_cliente', 'Observaciones:');
define('agenda_save_changes', 'Guardar cambios');
define('agenda_jornada_manana', 'Mañana');
define('agenda_jornada_tarde', 'Tarde');

// tratamientos
define('agenda_tratamiento', 'Tratamiento');
define('agenda_info_tratamiento', 'Información del Tratamiento');
define('agenda_fehca_tratamiento', 'Fecha Resgistro');
define('agenda_valor_tratamiento', 'Valor');
define('agenda_estado_tratamiento', 'Estado Pago');
define('agenda_abonos_tratamiento', 'Abonos');
define('agenda_add_tratamiento', 'Formulario - Crear Tratamiento');
define('agenda_edit_tratamiento', 'Formulario - Editar tratamiento {0}');

define('agenda_precio_tratamiento', 'Valor');
define('agenda_observacion_tratamiento', 'Observación');
define('agenda_observacion_tratamiento_placeholder', 'Escríba la observación del tratamiento');
define('agenda_abono_tratamiento', 'Abono');

define('agenda_abono_fecha', 'Fecha del abono');
define('agenda_saldo_tratamiento', 'Saldo');

// mensajes tratamientos
define('general_title_pago_tratamiento', 'Clic aquí para realizar un abono al tratamiento {0}');
define('agenda_no_delete', 'No se puede eliminar el tratamiento: <b>{0}</b> porque tiene pagos o abonos realizados');
define('agenda_valor_abonar_filed_tratamiento', 'El valor a abonar no puede ser menor a <b>$ 1.000</b> pesos y mayor al <strong>valor del tratamiento</strong>');
define('agenda_valor_filed_tratamiento', 'El valor del tratamiento no puede ser menor a <b>$ 1.000</b>');

// Abonos
define('agenda_form_abonos', 'Formulario de abonos o pagos realizados - Tratamiento {0}');
define('agenda_nro_pago', 'No. <b>{0}</b>');
define('agenda_descripcion_message', 'Descripción: <b style="font-size: 11px;">{0}</b>');
define('agenda_usuario', 'Usuario: <b>{0}</b>');
define('agenda_usuario_persona', 'Nombre: <b>{0}</b>');
define('agenda_info_pagos', 'Información de los abonos');
define('agenda_realizar_abono', 'Realizar Pago');
define('agenda_total_tratamiento', 'Total Tratamiento:');
define('agenda_total_abonos', 'Total Abonos:');
define('agenda_total_saldo', 'Saldo:');
define('agenda_descripcion', 'Descripción del abono');
define('agenda_descripcion_placeholder', 'Escríba la descripción del abono');
define('agenda_minimo_valor_abono', 'El abono debe ser superior a Mil pesos ($1000)');

define('agenda_deletee_abono', 'Eliminar Abono');
define('agenda_download_recibo', 'Descargar Recibo');
define('agenda_print_recibo', 'Imprimir Recibo');
define('agenda_valor_cancelar', 'Valor a cancelar');
// mensajes pagos
define('agenda_message_valor_fail', 'El valor ingresado es mayor mayor al valor total de la deuda');
define('agenda_message_total_abono_failed', 'La suma de los pagos supera el valor total del tratamiento: {0}');
define('agenda_message_del_pago_ok', 'El abono se eliminó con éxito!');
define('agenda_message_abono_ok', 'El abono se realizó con éxito!');
define('agenda_message_abono_failed', 'Se presentó un error al realizar el abono por favor intenta nuevamente');
define('agenda_message_delete_abono_failed', 'Se presentó un error al eliminar el abono por favor intenta nuevamente');

