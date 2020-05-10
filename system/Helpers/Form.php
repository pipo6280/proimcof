<?php
namespace system\Helpers;

use system\Helpers\Lang;
use app\enums\EMeses;
use system\Core\Config;
use system\Support\Arr;
use system\Support\Str;
use system\Support\Util;
use system\Libraries\Validation;
use system\Core\Persistir;
use system\Session\Session;

/**
 *
 * @tutorial Clase de trabajo
 * @author Rodolfo Perez || pipo6280@gmail.com
 * @since 30/07/2015
 */
class Form
{

    public static function open($options = array())
    {
        $defaults = array(
            'action' => Config::instance()->baseUrl(),
            'method' => 'post',
            'role' => 'form'
        );
        if (! Arr::isNullArray('action', $options)) {
            if (Str::strpos($options['action'], '@')) {
                $options['action'] = Str::lower($options['action']);
                $options['action'] = Arr::explode($options['action'], '@');
                $options['action'] = Arr::implode($options['action'], '/');
                $options['action'] = Config::instance()->slashItem('base_url') . $options['action'];
                unset($defaults['action']);
            }
        }
        return '<form ' . set_attributes($options, $defaults) . ">\n" . static::token();
    }

    public static function close($extra = '')
    {
        return '</form>' . $extra;
    }

    public static function token()
    {
        $options = array(
            'type' => 'hidden'
        );
        return static::text('_token', Util::sha1(md5(Util::uniqid(Util::rand(), true))), $options);
    }

    public static function label($text, $id = '', $options = array())
    {
        $defaults = [
            'for' => Util::isVacio($id) ? $text : $id
        ];
        $options = is_array($options) ? $options : [
            'class' => $options
        ];
        return '<label ' . set_attributes($options, $defaults) . '>' . $text . '</label>';
    }

    public static function text($name, $value = '', $options = array())
    {
        $defaults = array(
            'type' => 'text',
            'value' => $value,
            'name' => $name,
            'class' => 'form-control'
        );
        if (! isset($options['id']) && isset($name)) {
            $defaults['id'] = $name;
        }
        if (! Arr::isNullArray('readonly', $options)) {
            if (! $options['readonly'])
                unset($options['readonly']);
            else
                $options['readonly'] = 'readonly';
        }
        if (! Arr::isNullArray('disabled', $options)) {
            if (! $options['disabled'])
                unset($options['disabled']);
            else
                $options['disabled'] = 'disabled';
        }
        return '<input ' . set_attributes($options, $defaults) . '/>';
    }

    public static function number($name, $value = '', $options = array())
    {
        $defaults = array(
            'type' => 'number'
        );
        $defaults = Arr::arrayMerge($defaults, $options);
        return static::text($name, $value, $defaults);
    }

    public static function password($name, $value = '', $options = array())
    {
        $defaults = array(
            'type' => 'password'
        );
        $defaults = Arr::arrayMerge($defaults, $options);
        return static::text($name, $value, $defaults);
    }

    public static function hide($name, $value, $options = array())
    {
        $defaults = array(
            'type' => 'hidden'
        );
        $defaults = Arr::arrayMerge($defaults, $options);
        return static::text($name, $value, $defaults);
    }

    public static function email($name, $value = '', $options = array())
    {
        $defaults = array(
            'type' => 'email'
        );
        $defaults = Arr::arrayMerge($defaults, $options);
        return static::text($name, $value, $defaults);
    }

    public static function url($name, $value = '', $options = array())
    {
        $defaults = array(
            'type' => 'url'
        );
        $defaults = Arr::arrayMerge($defaults, $options);
        return static::text($name, $value, $defaults);
    }

    public static function file($name, $value = '', $options = array())
    {
        $options = Arr::merge(array(
            'class' => 'form-control'
        ), $options);
        return static::input('file', $name, $value, $options);
    }

    public static function input($type, $name, $value = '', $options = array())
    {
        $defaults = array(
            'type' => $type
        );
        $defaults = Arr::arrayMerge($defaults, $options);
        return static::text($name, $value, $defaults);
    }

    public static function textarea($name, $value = '', $options = array())
    {
        $defaults = array(
            'name' => $name,
            'rows' => 3,
            'class' => 'form-control autosize',
            'style' => 'resize: vertical;'
        );
        if (! isset($options['id']) && isset($name)) {
            $defaults['id'] = $name;
        }
        return "<textarea " . set_attributes($options, $defaults) . ">" . validate_attributes($value, $name) . "</textarea>";
    }

    public static function date($name, $value, $options = array())
    {
        $defaults = array(
            'type' => 'date',
            'class' => 'datepicker'
        );
        $defaults = Arr::arrayMerge($defaults, $options);
        return static::text($name, $value, $defaults);
    }

    public static function submit($name, $value, $options = array())
    {
        $defaults = array(
            'type' => 'submit',
            'class' => 'btn btn-primary'
        );
        $defaults = Arr::arrayMerge($defaults, $options);
        return static::text($name, $value, $defaults);
    }

    public static function select($name, $data = array(), $value = '', $options = array())
    {
        $defaults = array(
            'name' => $name
        );
        $select = '<select ' . set_attributes($options, $defaults) . '>';
        $options = array();
        foreach ($data as $key => $arr) {
            if (Arr::isArray($arr)) {
                if (Arr::count($arr) > 0) {
                    $options[] = '<optgroup label="' . $key . '">';
                    foreach ($arr as $keySub => $ar) {
                        $selected = '';
                        if ($keySub == $value) {
                            $selected = 'selected="selected"';
                        }
                        $options[] = '<option value="' . $keySub . '" ' . $selected . '>' . $ar . '</option>';
                    }
                    $options[] = '</optgroup>';
                }
            } else {
                $selected = '';
                if ($key == $value) {
                    $selected = 'selected="selected"';
                }
                $options[] = "<option value=\"$key\" $selected>$arr</option>";
            }
        }
        $select .= Arr::implode($options, '');
        $select .= '</select>';
        unset($options);
        return $select;
    }

    public static function selectRange($name, $init, $end, $value = '', $options = array())
    {
        $defaults = array(
            'name' => $name
        );
        $select = '<select ' . set_attributes($options, $defaults) . '>';
        for ($i = $init; $i <= $end; $i ++) {
            $selected = '';
            if ($i == $value) {
                $selected = 'selected="selected"';
            }
            $select .= "<option value=\"$i\" $selected>$i</option>";
        }
        $select .= '</select>';
        return $select;
    }

    public static function selectYear($name, $init, $end, $value = '', $options = array(), $defaultOption = TRUE, $defaultWord = '')
    {
        return static::selectRange($name, $init, $end, $value, $options);
    }

    public static function selectMonth($name, $value = '', $options = array())
    {
        return static::selectEnum($name, $value, Util::mesesEnum(), $options);
    }

    public static function selectEnum($name, $value, array $data, array $options = NULL, $defaultOption = true, $defaultWord = '')
    {
        $defaults = array(
            'name' => $name,
            'class' => 'form-control chosen-select'
        );
        if (! isset($options['id']) && isset($name)) {
            $defaults['id'] = $name;
        }
        if (Arr::isArray($options) && ! Arr::isNullArray('disabled', $options)) {
            if ($options['disabled'] == FALSE) {
                unset($options['disabled']);
            } else {
                $options['disabled'] = 'disabled';
            }
        }
        $select = '<select ' . set_attributes($options, $defaults) . ' >';
        if ($defaultOption) {
            $defaultWord = Util::isVacio($defaultWord) ? lang('general.option_choose') : $defaultWord;
            $select .= '<option value="" selected>' . $defaultWord . '</option>';
        }
        foreach ($data as $d) {
            $select .= '<option value="' . $d->getId() . '" ' . ($value == $d->getId() ? 'selected="selected"' : '') . '>' . $d->getDescription() . '</option>';
        }
        $select .= '</select>';
        unset($data);
        unset($options);
        return $select;
    }

    public static function checkbox($name, $value = '', $checked = FALSE, $options = array())
    {
        $defaults = array(
            'type' => 'checkbox',
            'class' => '',
            'name' => $name
        );
        if (Arr::isArray($options) && ! Arr::isNullArray('checked', $options)) {
            $checked = $options['checked'];
            if ($checked == FALSE) {
                unset($options['checked']);
            } else {
                $options['checked'] = 'checked';
            }
        }
        if ($checked == TRUE) {
            $defaults['checked'] = 'checked';
        } else {
            unset($defaults['checked']);
        }
        if (! isset($options['id']) && isset($name)) {
            $defaults['id'] = $name;
        }
        $defaults = Arr::arrayMerge($defaults, $options);
        return static::text($name, $value, $defaults);
    }

    public static function radio($name, $value = '', $checked = FALSE, $options = array())
    {
        $defaults = array(
            'type' => 'radio',
            'class' => 'with-gap'
        );
        $defaults = Arr::arrayMerge($defaults, $options);
        return static::checkbox($name, $value, $checked, $defaults);
    }

    public static function reset($value, $options = array())
    {
        $defaults = array(
            'type' => 'reset'
        );
        $defaults = Arr::arrayMerge($defaults, $options);
        return static::text('', $value, $defaults);
    }

    public static function image($url, $name = '', $options = array())
    {
        $url = array(
            Config::instance()->setSlash_item('base_url'),
            Lang::text('EM_RESOURCEPATH', array(
                $url
            ))
        );
        $defaults = array(
            'src' => Arr::implode($url, ''),
            'type' => 'image'
        );
        $defaults = Arr::arrayMerge($defaults, $options);
        return '<input ' . set_attributes($options, $defaults) . '/>';
    }

    public static function button($value = '', $options = array())
    {
        $defaults = array(
            'id' => ! Arr::isArray($options) ? $options : '',
            'class' => 'btn btn-primary tooltipstered',
            'data-style' => 'expand-right',
            'type' => 'button'
        );
        return "<button " . set_attributes($options, $defaults) . ">" . $value . "</button>";
    }

    public static function switchs($value, $label, $options, $others = '')
    {
        $switchs = '<div class="switch">';
        $switchs .= $label . ' : ';
        $switchs .= '<label>';
        $switchs .= 'Off';
        $switchs .= static::checkbox($value, $options, $others);
        $switchs .= '<span class="lever"></span> On';
        $switchs .= '</label>';
        $switchs .= '</div>';
        
        return $switchs;
    }

    public static function postId()
    {
        $resultado = "<input type='hidden' name='postID' ";
        $resultado .= "value='" . md5(uniqid(rand(), true)) . "'>";
        return $resultado;
    }

    public static function isError($prefix = '', $suffix = '')
    {
        $error = Validation::instance()->errorString($prefix, $suffix);
        return $error;
    }

    public static function isDobleEnvio()
    {
        return Persistir::getParam('_token') != NULL && ! static::validateDobleClick(Persistir::getParam('_token'));
    }

    public static function validateDobleClick($_token)
    {
        $valida = Session::getData('_token');
        if (empty($valida)) {
            $valida = array();
        } elseif (! is_array($valida)) {
            $valida = array(
                $valida
            );
            $_SESSION['_token'] = $valida;
        }
        if (count($valida) > 0) {
            if (in_array($_token, $valida)) {
                return false;
            } else {
                $_SESSION['_token'][] = $_token;
                return true;
            }
        } else {
            $_SESSION['_token'][] = $_token;
            return true;
        }
    }
}