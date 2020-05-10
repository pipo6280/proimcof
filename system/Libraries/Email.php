<?php
namespace system\Libraries;

use system\Core\Singleton;

class Email extends Singleton
{

    private $phpMailer;

    /**
     *
     * @var string
     */
    protected $log_errors;

    public function __construct()
    {
        $this->phpMailer = new \PHPMailer();
    }

    /**
     *
     * @tutorial Method Description: envia un email
     * @author Rodolfo Perez ~ pipo6280@gmail.com
     * @since {23/04/2016}
     * @param array $options            
     * @return Ambigous <string, \system\Helpers\mixed, mixed>
     */
    public function sendMail($options)
    {
        // Valores por defecto
        $defaultOptions = array(
            'smtp_secure' => EM_SMTP_SECURE,
            'smtp_host' => EM_SMTP_HOST,
            'smtp_port' => EM_SMTP_PORT,
            'smtp_user' => EM_SMTP_USER,
            'smtp_pass' => EM_SMTP_PASSWORD,
            'smtp_charset' => EM_SMTP_CHARSET,
            'mailtype' => true,
            "from" => EM_SMTP_USER,
            "from_name" => NULL,
            "subject" => "",
            "message" => "",
            "to" => array(),
            "cc" => array(),
            "cco" => array(),
            "attachment" => array(),
            'language' => 'es'
        );
        $options = array_merge($defaultOptions, $options);
        // Inicializamos los parametros de la clase phpmailer
        $this->phpMailer->IsSMTP();
        $this->phpMailer->setLanguage($options['language']);
        $this->phpMailer->SMTPAuth = true;
        $this->phpMailer->SMTPSecure = $options['smtp_secure'];
        $this->phpMailer->Host = $options['smtp_host'];
        $this->phpMailer->Port = $options['smtp_port'];
        
        $this->phpMailer->Username = $options["smtp_user"];
        $this->phpMailer->Password = $options["smtp_pass"];
        $this->phpMailer->CharSet = $options["smtp_charset"];
        
        // Enviamos el mensaje
        $this->phpMailer->From = $options["from"];
        $this->phpMailer->FromName = $options["from_name"];
        $this->phpMailer->Subject = $options["subject"];
        $this->phpMailer->MsgHTML($options["message"]);
        
        // Agregamos los destinatarios
        foreach ($options["to"] as $email => $name) {
            $this->phpMailer->AddAddress($email, $name);
        }
        // Agregamos los destinatarios copia
        foreach ($options["cc"] as $email => $name) {
            $this->phpMailer->AddCC($email, $name);
        }
        // Agregamos los destinatarios copia oculta
        foreach ($options["cco"] as $email => $name) {
            $this->phpMailer->AddBCC($email, $name);
        }
        // Adjuntos
        foreach ($options["attachment"] as $f) {
            $this->phpMailer->AddAttachment($f["file"], $f["name_file"]);
        }
        $this->phpMailer->IsHTML($options['mailtype']);
        if (! $this->phpMailer->Send()) {
            $this->phpMailer->ErrorInfo;
            return false;
        } else {
            return true;
        }
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez ~ pipo6280@gmail.com
     * @since {23/04/2016}
     * @return string
     */
    public function getLog_errors()
    {
        return $this->log_errors;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez ~ pipo6280@gmail.com
     * @since {23/04/2016}
     * @param string $log_errors            
     */
    public function setLog_errors($log_errors)
    {
        $this->log_errors = $log_errors;
    }
}