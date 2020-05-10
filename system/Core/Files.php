<?php
namespace system\Core;

use app\dtos\ADto;
use system\Support\Arr;
use system\Support\Util;
use system\Support\Str;

class Files extends ADto
{

    private $_file;

    private $type;

    private $size;

    private $folder;

    private $name;

    private $temp;

    private $extensions;

    private $formats;

    private $dimensiones;

    private static $permitImage = array(
        'image/jpeg',
        'image/pjpeg',
        'image/png',
        'image/gif',
        'image/jpg'
    );

    private static $permitArchivos = array(
        'application/msword',
        'image/pjpeg',
        'image/png',
        'image/gif',
        'image/jpg'
    );

    private $permit;

    private $validaTipo;

    private $validaPeso;

    private $validaDimensiones;

    private $array;

    /**
     *
     * @tutorial Method Description:
     * @author Miguel Carmona
     * @since {27/11/2015}
     */
    public function __construct()
    {
        $this->array = array();
        $this->formats = array(
            'txt' => 'text/plain',
            'htm' => 'text/html',
            'html' => 'text/html',
            'php' => 'text/html',
            'css' => 'text/css',
            'js' => 'application/javascript',
            'json' => 'application/json',
            'xml' => 'application/xml',
            'swf' => 'application/x-shockwave-flash',
            'flv' => 'video/x-flv',
            
            // images
            'png' => 'image/png',
            'jpg' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'gif' => 'image/gif',
            'bmp' => 'image/bmp',
            'ico' => 'image/vnd.microsoft.icon',
            'tiff' => 'image/tiff',
            'tif' => 'image/tiff',
            'svg' => 'image/svg+xml',
            'svgz' => 'image/svg+xml',
            
            // archives
            'zip' => array(
                'application/zip',
                'application/octet-stream'
            ),
            'rar' => array(
                'application/x-rar-compressed',
                'application/x-rar'
            ),
            
            // audio/video
            'mp3' => array(
                'audio/mpeg',
                'audio/mp3'
            ),
            'qt' => 'video/quicktime',
            'mov' => 'video/quicktime',
            
            // adobe
            'pdf' => 'application/pdf',
            'psd' => 'image/vnd.adobe.photoshop',
            'ai' => 'application/postscript',
            'eps' => 'application/postscript',
            'ps' => 'application/postscript',
            
            // ms office
            'doc' => array(
                'application/msword',
                'application/x-empty',
                'application/vnd.ms-office'
            ),
            'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'rtf' => 'application/rtf',
            'xls' => 'application/vnd.ms-excel',
            'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'ppt' => 'application/vnd.ms-powerpoint',
            'pptx' => 'application/vnd.openxmlformats-officedocument.presentationml.presentation',
            
            // open office
            'odt' => 'application/vnd.oasis.opendocument.text',
            'ods' => 'application/vnd.oasis.opendocument.spreadsheet'
        );
        parent::__construct();
    }

    public function getValidate()
    {
        $correcto = TRUE;
        if ($this->validaPeso) {
            $max_tamano = $this->array['peso'] * (1024 * 1024);
            if ($this->size > $max_tamano) {
                Message::addError(NULL, 'aqui mensaje'); // Lang::getText('ERROR_PESO_ARCHIVO'));
                $correcto = FALSE;
            }
        }
        if ($this->validaTipo) {
            $valores = array();
            switch (Str::upper($this->permit)) {
                case 'IMAGE':
                case 'IMAGES':
                    {
                        $valores = self::$permitImage;
                    }
                    break;
            }
            if (! Arr::inArray($this->type, $valores)) {
                Message::addError(NULL, 'aqui mensaje');
                $correcto = FALSE;
            } else {
                if ($this->validaDimensiones) {
                    if ($this->dimensiones['width'] > $this->array['dimensiones']['width'] || $this->dimensiones['height'] > $this->array['dimensiones']['height']) {
                        Message::addError(NULL, 'aqui mensaje'); // Lang::getText('ERROR_DIMENSIONES_IMAGEN'));
                        $correcto = FALSE;
                    }
                }
            }
        }
        return $correcto;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Miguel Carmona
     * @since {27/11/2015}
     * @param unknown $_file            
     * @return boolean
     */
    public function addUpload($_file)
    {
        $this->name = $_file["name"];
        $this->size = $_file["size"];
        $this->type = $_file["type"];
        $this->temp = $_file["tmp_name"];
        $this->_file = file_get_contents($_file["tmp_name"]);
        
        $partes = Arr::explode($this->name, '.');
        $ext = $partes[Arr::count($partes) - 1];
        
        if (Arr::inArray($this->type, self::$permitImage)) {
            $imagen = getimagesize($this->temp);
            $ancho = $imagen[0];
            $alto = $imagen[1];
            $this->dimensiones = array(
                'width' => $ancho,
                'height' => $alto
            );
        }
        
        foreach ($this->formats as $key => $f) {
            if (Arr::isArray($f)) {
                foreach ($f as $keyy => $ff) {
                    if ($ff == $this->type) {
                        $this->extensions = $ext;
                        break;
                    }
                }
            } else {
                if ($f == $this->type) {
                    $this->extensions = $ext;
                }
            }
            if (! Util::isVacio($this->extensions)) {
                break;
            }
        }
        if (Util::isVacio($this->extensions)) {
            Message::addError(NULL, 'La extensión que desea ingresar no es soportada');
            return FALSE;
        }
        return TRUE;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Miguel Carmona
     * @since {27/11/2015}
     * @param unknown $_file            
     * @param unknown $carpeta            
     * @return boolean
     */
    public function addFile($_file, $carpeta = NULL)
    {
        $finfo = new \finfo();
        $this->name = $_file;
        if (file_exists($carpeta . $_file)) {
            $this->size = filesize($carpeta . $_file);
            $this->type = $finfo->file($carpeta . $_file, FILEINFO_MIME_TYPE);
            $this->temp = $carpeta . $_file;
            $this->_file = file_get_contents($carpeta . $_file);
            $partes = Arr::explode($this->name, '.');
            $ext = $partes[Arr::count($partes) - 1];
            if (Arr::inArray($this->type, self::$permitImage)) {
                $imagen = getimagesize($this->temp); // Sacamos la informaci�n
                $ancho = $imagen[0]; // Ancho
                $alto = $imagen[1];
                $this->dimensiones = array(
                    'width' => $ancho,
                    'height' => $alto
                );
            }
            
            foreach ($this->formats as $key => $f) {
                if (Arr::isArray($f)) {
                    foreach ($f as $keyy => $ff) {
                        if ($ff == $this->type) {
                            $this->extensions = $ext;
                            break;
                        }
                    }
                } else {
                    if ($f == $this->type) {
                        $this->extensions = $ext;
                    }
                }
                if (! Util::isVacio($this->extensions)) {
                    break;
                }
            }
            if (Util::isVacio($this->extensions)) {
                Message::addError(NULL, 'La extensi�n que desea ingresar no es soportada');
                return FALSE;
            }
            return TRUE;
        }
        return FALSE;
    }

    public function getHeaderWrite()
    {
        header('Content-Description: ' . $this->type);
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=' . $this->folder . $this->getNameShort() . '.' . $this->extensions);
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Pragma: public');
        header('Accept-Ranges: bytes');
        header('Content-Length: ' . $this->size);
        header('Connection: close');
        ob_clean();
        flush();
        echo $this->getContent();
        exit();
    }

    public function getWriteListFile($folder, $list)
    {
        foreach ($list as $f) {
            $f->setFolder($folder);
            $f->getWriteFile();
        }
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez ~~ pipo6280@gmail.com
     * @since {30/11/2015}
     * @param Files $filename            
     * @return boolean
     */
    public function link($filename)
    {
        return unlink($filename);
    }

    /**
     *
     * @tutorial Method Description:
     * @author Miguel Carmona
     * @since {27/11/2015}
     * @return string
     */
    protected function getNameShort()
    {
        $partes = Arr::explode($this->name, '.');
        unset($partes[Arr::count($partes) - 1]);
        return implode('', $partes);
    }

    public function getWriteFile()
    {
        try {
            $fileNew = fopen($this->folder . $this->name, "w");
            fwrite($fileNew, $this->getContent());
            fclose($fileNew);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    protected function getHeader()
    {
        header("Content-type:" . $this->type);
        echo $this->getContent();
    }

    public function getContent()
    {
        return $this->_file;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Miguel Carmona
     * @since {27/11/2015}
     * @return Ambigous <unknown, multitype:unknown >
     */
    public final function getDimensiones()
    {
        return $this->dimensiones;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Miguel Carmona
     * @since {27/11/2015}
     * @param unknown $dimensiones            
     */
    public final function setDimensiones($dimensiones)
    {
        $this->dimensiones = $dimensiones;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Miguel Carmona
     * @since {27/11/2015}
     * @return unknown
     */
    public final function getValidaTipo()
    {
        return $this->validaTipo;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Miguel Carmona
     * @since {27/11/2015}
     * @param unknown $validaTipo            
     * @param string $permit            
     */
    public final function setValidaTipo($validaTipo, $permit = 'image')
    {
        $this->permit = $permit;
        $this->validaTipo = $validaTipo;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Miguel Carmona
     * @since {27/11/2015}
     * @return unknown
     */
    public final function getValidaPeso()
    {
        return $this->validaPeso;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Miguel Carmona
     * @since {27/11/2015}
     * @return unknown
     */
    public final function getValidaDimensiones()
    {
        return $this->validaDimensiones;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Miguel Carmona
     * @since {27/11/2015}
     * @param unknown $validaPeso            
     * @param number $peso            
     */
    public final function setValidaPeso($validaPeso, $peso = 8)
    {
        $this->validaPeso = $validaPeso;
        $this->array['peso'] = $peso;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Miguel Carmona
     * @since {27/11/2015}
     * @param unknown $validaDimensiones            
     * @param unknown $tamano            
     */
    public final function setValidaDimensiones($validaDimensiones, $tamano = array('width'=>100,'height'=>120))
    {
        $this->validaDimensiones = $validaDimensiones;
        $this->array['dimensiones'] = $tamano;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Miguel Carmona
     * @since {27/11/2015}
     * @return Ambigous <unknown, string>
     */
    public final function getFile()
    {
        return $this->_file;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Miguel Carmona
     * @since {27/11/2015}
     * @return Ambigous <unknown, unknown>
     */
    public final function getType()
    {
        return $this->type;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Miguel Carmona
     * @since {27/11/2015}
     * @return Ambigous <unknown, number, unknown>
     */
    public final function getSize()
    {
        return $this->size;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Miguel Carmona
     * @since {27/11/2015}
     * @return unknown
     */
    public final function getFolder()
    {
        return $this->folder;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Miguel Carmona
     * @since {27/11/2015}
     * @return Ambigous <unknown, unknown>
     */
    public final function getName()
    {
        return $this->name;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Miguel Carmona
     * @since {27/11/2015}
     * @return Ambigous <unknown, multitype:string multitype:string >
     */
    public final function getFormats()
    {
        return $this->formats;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Miguel Carmona
     * @since {27/11/2015}
     * @param unknown $_file            
     */
    public final function setFile($_file)
    {
        $this->_file = $_file;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Miguel Carmona
     * @since {27/11/2015}
     * @param unknown $type            
     */
    public final function setType($type)
    {
        $this->type = $type;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Miguel Carmona
     * @since {27/11/2015}
     * @param unknown $size            
     */
    public final function setSize($size)
    {
        $this->size = $size;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Miguel Carmona
     * @since {27/11/2015}
     * @param unknown $folder            
     */
    public final function setFolder($folder)
    {
        $this->folder = $folder;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Miguel Carmona
     * @since {27/11/2015}
     * @param unknown $name            
     */
    public final function setName($name)
    {
        $this->name = $name;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Miguel Carmona
     * @since {27/11/2015}
     * @param unknown $formats            
     */
    public final function setFormats($formats)
    {
        $this->formats = $formats;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Miguel Carmona
     * @since {27/11/2015}
     * @return Ambigous <unknown, unknown>
     */
    public final function getExtensions()
    {
        return $this->extensions;
    }

    /**
     *
     * @tutorial Method Description:
     * @author Miguel Carmona
     * @since {27/11/2015}
     * @param unknown $extensions            
     */
    public final function setExtensions($extensions)
    {
        $this->extensions = $extensions;
    }
}