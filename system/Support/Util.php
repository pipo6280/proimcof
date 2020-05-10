<?php
namespace system\Support;

use system\Session\Session;
use system\Support\Arr;
use system\Support\Str;
use app\enums\EDateFormat;
use app\enums\EnumGeneric;
use system\Core\Singleton;
use app\dtos\SessionDto;

/**
 *
 * @tutorial Clase de trabajo
 * @author Rodolfo Perez || pipo6280@gmail.com
 * @since 4/12/2016
 */
class Util extends Singleton
{

    protected static function initialize()
    {}

    public static function setObjectRow($object, $row)
    {
        foreach ($row as $campo => $valor) {
            $temporal = 'set' . Str::ucWords(mb_strtolower($campo));
            if (method_exists($object, $temporal)) {
                $object->$temporal($valor);
            }
            unset($campo);
            unset($valor);
            unset($temporal);
        }
        unset($row);
    }

    public static function formatNumber($number, $decimals = null, $search = ',', $replace = '.')
    {
        $number = ((int) $number <= 0) ? 0 : $number;
        return number_format($number, $decimals, $search, $replace);
    }

    public static function ceroToNull($var)
    {
        $cadena = NULL;
        if ($var != NULL) {
            if ($var > 0) {
                $cadena = $var;
            }
        }
        return $cadena;
    }
    
    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {7/02/2018}
     * @param unknown $var
     * @return Ambigous <number, unknown>
     */
    public static function NullToCero($var)
    {
        $val = 0;
        if ($var != NULL) {
            if ($var > 0) {
                $val = $var;
            }
        }
        return $val;
    }

    public static function isString($var)
    {
        return is_string($var);
    }

    public static function isIsset($var)
    {
        return isset($var);
    }

    public static function isVacio($var)
    {
        $vacio = false;
        if (! Arr::isArray($var)) {
            $cadena = static::isNull($var) || Str::strlen(static::trim($var)) == 0 ? '' : $var;
            $cadena = static::trim($cadena);
            if (Str::strlen($cadena) < 1) {
                $vacio = true;
            }
            unset($cadena);
        } else {
            $vacio = (Arr::count($var) < 1);
        }
        unset($var);
        return $vacio;
    }

    public static function isNull($var)
    {
        return is_null($var);
    }

    public static function trim($text, $charlist = null)
    {
        return trim($text, $charlist);
    }

    public static function lTrim($str, $charlist = null)
    {
        return ltrim($str, $charlist);
    }

    public static function fileExists($filename)
    {
        $filename = Str::replaceWord('\\', '/', $filename);
        return file_exists($filename);
    }

    public static function sha1($str)
    {
        return sha1($str);
    }

    public static function md5($str)
    {
        return md5($str);
    }

    public static function serialize($value)
    {
        return serialize($value);
    }

    public static function unserialize($str)
    {
        return unserialize($str);
    }

    public static function arrayMap($callback, $array1)
    {
        return array_map($callback, $array1);
    }

    public static function htmlSpecialChars($string, $codificacion = NULL)
    {
        return htmlspecialchars($string, $codificacion);
    }

    public static function rand($min = 0, $max = 0)
    {
        return rand($min, $max);
    }

    public static function time()
    {
        return microtime_float();
    }

    public static function uniqid($prefix = null, $more_entropy = null)
    {
        return uniqid($prefix, $more_entropy);
    }

    /**
     *
     * @tutorial Metodo Descripcion:
     * @author Rodolfo Perez || pipo6280@gmail.com
     * @since 20/11/2016
     * @return SessionDto
     */
    public static function userSessionDto()
    {
        return static::unserialize(Session::getData('sessionDto'));
    }

    public static function setUserSessionDto($sessionDto)
    {
        Session::setData('sessionDto', static::serialize($sessionDto));
    }

    public static function isObject($var)
    {
        return ! static::isNull($var) && is_object($var) && ! static::isArray($var);
    }

    public static function classExists($class_name, $autoload = true)
    {
        return class_exists($class_name, $autoload);
    }

    public static function isNumeric($var)
    {
        return is_numeric($var);
    }

    public static function round($val, $precision = null, $mode = null)
    {
        return round($val, $precision, $mode);
    }

    public static function size($var)
    {
        if (static::isObject($var) || static::isArray($var)) {
            $var = static::serialize($var);
        }
        $leng = static::strlen($var);
        $kilo = $leng / 1024;
        $kilo = number_format($kilo, 2);
        unset($leng);
        unset($var);
        return $kilo . ' KB';
    }

    public static function year()
    {
        return date('Y');
    }

    public static function fecha($timestamp = NULL, $format = 'Y-m-d H:i:s')
    {
        if (! static::isNumeric($timestamp)) {
            $timestamp = static::fechaNumero($timestamp);
        }
        return date($format, $timestamp);
    }

    public static function fechaNumero($fecha)
    {
        return strtotime($fecha);
    }

    public static function fechaActual($horas = FALSE)
    {
        $horas = ($horas) ? ' H:i:s' : NULL;
        return date("Y-m-d$horas");
    }

    public static function mkTime($hour = NULL, $minute = NULL, $second = NULL, $month = NULL, $day = NULL, $year = NULL)
    {
        return mktime($hour, $minute, $second, $month, $day, $year);
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {16/01/2017}
     * @param unknown $dateC            
     * @param unknown $options            
     * @return string
     */
    public static function sumarFecha($dateC, $options = array())
    {
        $defaultC = [
            'Y' => 0,
            'm' => 0,
            'd' => 0,
            'H' => 0,
            'i' => 0,
            's' => 0,
            'format' => 'Y-m-d H:i:s'
        ];
        $dateC = static::fecha(static::fechaNumero($dateC));
        $options = Arr::arrayMerge($defaultC, $options);
        list ($fechaC, $horaC) = Arr::explode($dateC, ' ');
        list ($anoC, $mesC, $diaC) = Arr::explode($fechaC, '-');
        list ($horaC, $minutosC, $segundosC) = Arr::explode($horaC, ':');
        
        $mktimeC = static::mkTime(($horaC + $options['H']), ($minutosC + $options['i']), ($segundosC + $options['s']), ($mesC + $options['m']), ($diaC + $options['d']), ($anoC + $options['Y']));
        return static::fecha($mktimeC, $options['format']);
    }

    public static function restarFecha($date, $options = array())
    {
        $defaultC = array(
            "A" => 0,
            "m" => 0,
            "d" => 0,
            "H" => 0,
            "i" => 0,
            "s" => 0,
            'format' => 'Y-m-d'
        );
        $options = Arr::arrayMerge($defaultC, $options);
        list ($fecha, $hora) = Arr::explode($date, ' ');
        list ($A, $m, $d) = Arr::explode($fecha, '-');
        list ($H, $i, $s) = Arr::explode($hora, ':');
        $mktime = static::mktime($H - $options['H'], $i - $options['i'], $s - $options['s'], $m - $options['m'], $d - $options['d'], $A - $options['A']);
        return static::fecha($mktime, $options['format']);
    }
    
    
    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {13/02/2018}
     * @return multitype:\app\enums\EnumGeneric
     */
    public static function mesesEnum()
    {
        return array(
            new EnumGeneric(1, 'Enero'),
            new EnumGeneric(2, 'Febrero'),
            new EnumGeneric(3, 'Marzo'),
            new EnumGeneric(4, 'Abril'),
            new EnumGeneric(5, 'Mayo'),
            new EnumGeneric(6, 'Junio'),
            new EnumGeneric(7, 'Julio'),
            new EnumGeneric(8, 'Agosto'),
            new EnumGeneric(9, 'Septiembre'),
            new EnumGeneric(10, 'Octubre'),
            new EnumGeneric(11, 'Noviembre'),
            new EnumGeneric(12, 'Diciembre')
        );
    }

    /**
     *
     * @tutorial Method Description: retorna una array de los meses del año
     * @author Rodolfo Perez ~~ pipo6280@gmail.com
     * @since {21/12/2015}
     * @return multitype:string
     */
    public static function meses()
    {
        return array(
            1 => 'Enero',
            2 => 'Febrero',
            3 => 'Marzo',
            4 => 'Abril',
            5 => 'Mayo',
            6 => 'Junio',
            7 => 'Julio',
            8 => 'Agosto',
            9 => 'Septiembre',
            10 => 'Octubre',
            11 => 'Noviembre',
            12 => 'Diciembre'
        );
    }

    public static function mes($mes)
    {
        $meses = static::meses();
        $numero = (int) $mes;
        return $meses[$numero];
    }
    
    /**
     * 
     * @tutorial Method Description:
     * @author Rodolfo Perez Gomez -- pipo6280@gmail.com
     * @since {21/04/2018}
     * @return multitype:\app\enums\EnumGeneric
     */
    public static function getYearEnum() {
        $listYears = array();
        for($year = Date('Y'); $year >= YEAR_INI; $year--) {
            $listYears[] = new EnumGeneric($year, $year);
        }
        return $listYears;
    }

    /**
     *
     * @tutorial Method Description: metodo que trasforma la fecha string a datetime
     * @author Rodolfo Perez - pipo6280@gmail.com
     * @since {21/11/2015}
     * @param unknown $fecha            
     * @return Ambigous <unknown, \DateTime>
     */
    final public static function toDatetime($fecha)
    {
        $dateTime = $fecha;
        if ($fecha != NULL && ! ($fecha instanceof \DateTime)) {
            $dateTime = new \DateTime($fecha);
        }
        return $dateTime;
    }

    public static function formatDate($date, $format)
    {
        if ($date == '0000-00-00' or $date == '0000-00-00 00:00:00' or $date == '') {
            return '';
        } else {
            $date = static::fecha(static::fechaNumero($date));
            list ($fecha, $hora) = Arr::explode($date, ' ');
            list ($year, $month, $day) = Arr::explode($fecha, "-");
            switch ($format) {
                case EDateFormat::index(EDateFormat::MES_DIA_ANO)->getId():
                    list ($year, $month, $day) = Arr::explode($fecha, "-");
                    return static::mes($month) . " " . $day . " de " . $year;
                    break;
                case EDateFormat::index(EDateFormat::MES_DIA_ANO_HORA)->getId():
                    list ($year, $month, $day) = Arr::explode($fecha, "-");
                    $horaTxt = ($hora != '00:00:00' && $hora != '') ? ' Hora: ' . static::fecha(static::fechaNumero($date), 'h:i a') : '';
                    return static::mes($month) . " " . $day . " de " . $year . $horaTxt;
                    break;
                case EDateFormat::index(EDateFormat::MES_DIA_ANO_HORA_SLASH)->getId():
                    list ($year, $month, $day) = Arr::explode($fecha, "-");
                    return $day . "/" . $month . "/" . $year . ' ' . $hora;
                    break;
                case EDateFormat::index(EDateFormat::FORMAT_ABBREVIATED)->getId():
                    list ($year, $month, $day) = Arr::explode($fecha, "-");
                    return static::shortMonthName($month) . " " . $day . " de " . $year;
                    break;
                case EDateFormat::index(EDateFormat::SOLO_FECHA)->getId(): // retornar solo fecha
                    return $fecha;
                    break;
                case EDateFormat::index(EDateFormat::SOLO_ANO)->getId(): // retornar solo año
                    return $year;
                    break;
                case EDateFormat::index(EDateFormat::SOLO_MES)->getId(): // retornar solo mes
                    return static::mes($month);
                    break;
                case EDateFormat::index(EDateFormat::SOLO_DIA)->getId(): // retornar solo dia
                    return $day;
                    break;
                case EDateFormat::index(EDateFormat::DIA_MES_ANO_LETTER)->getId():
                    list ($year, $month, $day) = Arr::explode($fecha, "-");
                    return $day . " de " . static::mes($month) . " de " . $year;
                    break;
                case EDateFormat::index(EDateFormat::MES_DIA_ANO)->getId(): // Retorna fecha completa con dia de la semana
                    return static::dias(static::formatDay($fecha)) . ', ' . $day . " de " . static::mes($month) . " de " . $year;
                    break;
                case EDateFormat::index(EDateFormat::DIA_MES)->getId():
                    list ($year, $month, $day) = Arr::explode($fecha, "-");
                    return $day . " de " . static::mes($month);
                    break;
                case 11: // Retorna fecha completa con dia de la semana - abreviado
                    return static::dias(static::formatDay($fecha), false) . ', ' . $day . " " . static::mes($month) . " del " . $year;
                    break;
                case 12: // retornar fecha y hora
                    return $date;
                    break;
                case 13: // Solo hora
                    return $hora;
                    break;
                case 14:
                    list ($year, $month, $day) = Arr::explode($fecha, "-");
                    return $year . "-" . $month . "-" . $day;
                    break;
                case 15:
                    return static::shortMonthName($month) . " / " . $year;
                    break;
            }
        }
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez ~~ pipo6280@gmail.com
     * @since {21/12/2015}
     * @param \DateTime $fecha            
     * @param number $tipo            
     * @return mixed
     */
    public static function formatDay($fecha, $tipo = 0)
    {
        $date = Arr::explode($fecha, '-');
        return jddayofweek(cal_to_jd(CAL_GREGORIAN, $date[1], $date[2], $date[0]), $tipo);
    }

    /**
     *
     * @tutorial Method Description:
     * @author Rodolfo Perez ~~ pipo6280@gmail.com
     * @since {21/12/2015}
     * @param string $mes            
     * @return string
     */
    public static function shortMonthName($mes)
    {
        switch ($mes) {
            case 1:
                return 'Ene';
                break;
            case 2:
                return 'Feb';
                break;
            case 3:
                return 'Mar';
                break;
            case 4:
                return 'Abr';
                break;
            case 5:
                return 'May';
                break;
            case 6:
                return 'Jun';
                break;
            case 7:
                return 'Jul';
                break;
            case 8:
                return 'Ago';
                break;
            case 9:
                return 'Sep';
                break;
            case 10:
                return 'Oct';
                break;
            case 11:
                return 'Nov';
                break;
            case 12:
                return 'Dic';
                break;
        }
    }

    public static function dias($indice = '', $abr = false)
    {
        if ($abr) {
            $nombre = array(
                0 => 'Dom',
                1 => 'Lun',
                2 => 'Mar',
                3 => 'Mie',
                4 => 'Jue',
                5 => 'Vie',
                6 => 'Sab'
            );
        } else {
            $nombre = array(
                0 => 'Domingo',
                1 => 'Lunes',
                2 => 'Martes',
                3 => 'Miercoles',
                4 => 'Jueves',
                5 => 'Viernes',
                6 => 'Sabado'
            );
        }
        if ($indice === '') {
            return $nombre;
        } else {
            return $nombre[$indice];
        }
    }

    public static function horaAM()
    {
        $return = array();
        for ($i = 7; $i <= 12; $i ++) {
            $i = ($i < 10) ? '0' . $i : $i;
            for ($j = 0; $j < 60; $j += 15) {
                $hora = ($j == 0) ? ($i . ":" . '00') : ($i . ":" . $j);
                $listHora[] = $hora;
                if ($i == 12) {
                    break;
                }
            }
        }
        $return['horaReal'] = $listHora;
        $return['horaVer'] = $listHora;
        unset($i, $j, $hora, $listHora);
        return $return;
    }

    public static function horasPM()
    {
        $return = array();
        for ($i = 2; $i <= 7; $i ++) {
            $i = ($i < 10) ? '0' . $i : $i;
            for ($j = 0; $j < 60; $j += 15) {
                $hora = ($j == 0) ? $i . ":" . '00' : $i . ":" . $j;
                $listHora[] = $hora;
                $horaReal = ($j == 0) ? ($i + 12) . ":" . '00' : ($i + 12) . ":" . $j;
                $listHoraReal[] = $horaReal;
                if ($i == 7) {
                    break;
                }
            }
        }
        $return['horaReal'] = $listHoraReal;
        $return['horaVer'] = $listHora;
        unset($i, $j, $hora, $listHora, $horaReal, $listHoraReal);
        return $return;
    }

    public static function fechaCita($fecha, $hora)
    {
        return ($fecha . ' ' . $hora . ':00');
    }

    public static function comboAnos($anoInicial, $anoFinal)
    {
        $result = array();
        for ($i = $anoFinal; $i >= $anoInicial; $i --) {
            $obj = new EnumGeneric($i, $i);
            $result[] = $obj;
        }
        return $result;
    }

    public static function trimText($texto, $limite = 100)
    {
        $texto = trim($texto);
        $texto = strip_tags(nl2br($texto));
        $tamano = strlen($texto);
        $resultado = '';
        if ($tamano <= $limite) {
            return $texto;
        } else {
            $texto = substr($texto, 0, $limite);
            $palabras = explode(' ', $texto);
            $resultado = implode(' ', $palabras);
            $resultado .= '...';
        }
        return $resultado;
    }

    public static function cutText($cadena, $limite, $corte = " ", $pad = "...", $html = false)
    {
        if (strlen($cadena) <= $limite)
            return $cadena;
        if (false !== ($breakpoint = strpos($cadena, $corte, $limite))) {
            if ($breakpoint < strlen($cadena) - 1) {
                if ($html) {
                    $cadena = substr($cadena, 0, $breakpoint) . $pad;
                } else {
                    $cadena = substr(strip_tags(html_entity_decode(nl2br($cadena))), 0, $breakpoint) . $pad;
                }
            }
        }
        return $cadena;
    }
}