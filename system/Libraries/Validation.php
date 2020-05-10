<?php
namespace system\Libraries;

use system\Core\Singleton;
use system\Routing\Router;
use system\Support\Util;
use system\Helpers\Lang;
use system\Routing\Uri;
use system\Support\Arr;
use system\Support\Str;
use system\Core\Input;


class Validation extends Singleton
{

    protected $fieldData = array();
    protected $configRules = array();
    protected $errorArray = array();
    protected $errorMessages = array();
    protected $errorPrefix = '<p>';
    protected $errorSuffix = '</p>';
    protected $errorString = '';
    protected $safeFormData = FALSE;
    protected $validationData = array();

    public function __construct($rules = array())
    {
        // applies delimiters set in config file.
        if (isset($rules['errorPrefix'])) {
            $this->errorPrefix = $rules['errorPrefix'];
            unset($rules['errorPrefix']);
        }
        if (isset($rules['errorSuffix'])) {
            $this->errorSuffix = $rules['errorSuffix'];
            unset($rules['errorSuffix']);
        }
        // Validation rules can be stored in a config file.
        $this->configRules = $rules;
    }
    
    /**
     * 
     * @tutorial    This function takes an array of field names and validation, rules as input, any custom error messages, validates the info,and stores it	
     * @author 		Rodolfo Perez ~ pipo6280@gmail.com
     * @since 		{13/09/2015}
     * @param unknown $field
     * @param string $label
     * @param unknown $rules
     * @param unknown $errors
     * @return \system\Libraries\Validation
     */
    public function rules($field, $label = '', $rules = array(), $errors = array())
    {
        if (Input::instance()->getMethod() !== 'post' && Util::isVacio($this->validation_data)) {
            return $this;
        }
        if (Arr::isArray($field)) {
            foreach ($field as $row) {
                // Houston, we have a problem...
                if (! isset($row['field'], $row['rules'])) {
                    continue;
                }
                // If the field label wasn't passed we use the field name
                $label = isset($row['label']) ? $row['label'] : $row['field'];
                // Add the custom error message array
                $errors = (isset($row['errors']) && Util::isArray($row['errors'])) ? $row['errors'] : array();
                
                // Here we go!
                $this->rules($row['field'], $label, $row['rules'], $errors);
            }
            return $this;
        }
        // No fields? Nothing to do...
        if (! Util::isString($field) or $field === '') {
            return $this;
        } elseif (! Arr::isArray($rules)) {
            // BC: Convert pipe-separated rules string to an array
            if (Util::isString($rules)) {
                $rules = Arr::explode($rules, '|');
            } else {
                return $this;
            }
        }
        // If the field label wasn't passed we use the field name
        $label = ($label === '') ? $field : $label;
        $indexes = array();
        // Is the field name an array? If it is an array, we break it apart into its components so that we can fetch the corresponding POST data later
        if (($is_array = (bool) preg_match_all('/\[(.*?)\]/', $field, $matches)) === TRUE) {
            sscanf($field, '%[^[][', $indexes[0]);
            for ($i = 0, $c = Util::count($matches[0]); $i < $c; $i ++) {
                if ($matches[1][$i] !== '') {
                    $indexes[] = $matches[1][$i];
                }
            }
        }
        // Build our master array
        $this->fieldData[$field] = array(
            'field' => $field,
            'label' => $label,
            'rules' => $rules,
            'errors' => $errors,
            'is_array' => $is_array,
            'keys' => $indexes,
            'postdata' => NULL,
            'error' => ''
        );
        return $this;
    }
    
    /**
     * (non-PHPdoc)
     * @tutorial    {This function does all the work.}
     * @author 		{Rodolfo Perez ~ pipo6280@gmail.com}
     * @since 		{26/08/2015}
     * @param       string $group
     * @return      bool
     * @see         \system\Contracts\Validation\Validator::run()
     */
    public function run($group = '')
    {
        // Do we even have any data to process? Mm?
        $validationArray = Util::isVacio($this->validationData) ? $_POST : $this->validationData;
        if (Arr::count($validationArray) === 0) {
            return FALSE;
        }
        // Does the fieldData array containing the validation rules exist?
        // If not, we look to see if they were assigned via a config file
        if (Arr::count($this->fieldData) === 0) {
            // No validation rules? We're done...
            if (Util::count($this->configRules) === 0) {
                return FALSE;
            }
            if (Util::isVacio($group)) {
                // Is there a validation rule for the particular URI being accessed?
                $group = trim(Uri::instance()->getRuriString(), '/');
                isset($this->configRules[$group]) or $group = Router::instance()->getClass() . '/' . Router::instance()->getMethod();
            }
            $this->rules(isset($this->configRules[$group]) ? $this->configRules[$group] : $this->configRules);
            // Were we able to set the rules correctly?
            if (Arr::count($this->fieldData) === 0) {
                log_message('debug', 'Unable to find validation rules');
                return FALSE;
            }
        }
        // Load the lang file containing error messages
        Lang::load('form_validation');
        // Cycle through the rules for each field and match the corresponding $validation_data item
        foreach ($this->fieldData as $field => $row) {
            // Fetch the data from the validation_data array item and cache it in the fieldData array.
            // Depending on whether the field name is an array or a string will determine where we get it from.
            if ($row['is_array'] === TRUE) {
                $this->fieldData[$field]['postdata'] = $this->reduceArray($validationArray, $row['keys']);
            } elseif (isset($validationArray[$field]) && $validationArray[$field] !== '') {
                $this->fieldData[$field]['postdata'] = $validationArray[$field];
            }
        }
        // Execute validation rules
        // Note: A second foreach (for now) is required in order to avoid false-positives
        // for rules like 'matches', which correlate to other validation fields.
        foreach ($this->fieldData as $field => $row) {
            // Don't try to validate if we have no rules set
            if (Util::isVacio($row['rules'])) {
                continue;
            }
            $this->execute($row, $row['rules'], $this->fieldData[$field]['postdata']);
        }
        // Did we end up with any errors?
        $total_errors = Arr::count($this->errorArray);
        if ($total_errors > 0) {
            $this->safeFormData = TRUE;
        }
        // Now we need to re-set the POST data with the new, processed data
        $this->reset();
        return ($total_errors === 0);
    }
    
    /**
     * 
     * @tutorial    {This function does all the work.}	
     * @author 		{Rodolfo Perez ~ pipo6280@gmail.com}
     * @since 		{27/08/2015}
     * @param       string $row
     * @param       string $rules
     * @param       string $postdata
     * @param       number $cycles
     * @return      void
     */
    protected function execute($row, $rules, $postdata = NULL, $cycles = 0)
    {
        // If the $_POST data is an array we will run a recursive call
        if (Arr::isArray($postdata)) {
            foreach ($postdata as $key => $val) {
                $this->execute($row, $rules, $val, $key);
            }
            return;
        }
        // If the field is blank, but NOT required, no further tests are necessary
        $callback = FALSE;
        if (! Arr::inArray('required', $rules) && ($postdata === NULL or $postdata === '')) {
            // Before we bail out, does the rule contain a callback?
            foreach ($rules as &$rule) {
                if (Util::isString($rule)) {
                    if (strncmp($rule, 'callback_', 9) === 0) {
                        $callback = TRUE;
                        $rules = array(
                            1 => $rule
                        );
                        break;
                    }
                } elseif (is_callable($rule)) {
                    $callback = TRUE;
                    $rules = array(
                        1 => $rule
                    );
                    break;
                }
            }
            if (! $callback) {
                return;
            }
        }
        // Isset Test. Typically this rule will only apply to checkboxes.
        if (($postdata === NULL or $postdata === '') && ! $callback) {
            if (Arr::inArray('isset', $rules, TRUE) or Arr::inArray('required', $rules)) {
                // Set the message type
                $type = Arr::inArray('required', $rules) ? 'required' : 'isset';
                // Check if a custom message is defined
                if (isset($this->fieldData[$row['field']]['errors'][$type])) {
                    $line = $this->fieldData[$row['field']]['errors'][$type];
                } elseif (isset($this->errorMessages[$type])) {
                    $line = $this->errorMessages[$type];
                } elseif (FALSE === ($line = Lang::text('VALIDATION_' . Str::upper($type))) && FALSE === ($line = Lang::text('VALIDATION_' . Str::upper($type)))) {
                    $line = 'The field was not set';
                }
                // Build the error message
                $message = $this->buildError($line, $this->traslateField($row['label']));
                // Save the error message
                $this->fieldData[$row['field']]['error'] = $message;
                if (! isset($this->errorArray[$row['field']])) {
                    $this->errorArray[$row['field']] = $message;
                }
            }
            return;
        }
        // Cycle through each rule and run it
        foreach ($rules as $rule) {
            $_in_array = FALSE;
            // We set the $postdata variable with the current data in our master array so that
            // each cycle of the loop is dealing with the processed data from the last cycle
            if ($row['is_array'] === TRUE && Util::isArray($this->fieldData[$row['field']]['postdata'])) {
                // We shouldn't need this safety, but just in case there isn't an array index
                // associated with this cycle we'll bail out
                if (! isset($this->fieldData[$row['field']]['postdata'][$cycles])) {
                    continue;
                }
                $postdata = $this->fieldData[$row['field']]['postdata'][$cycles];
                $_in_array = TRUE;
            } else {
                // If we get an array field, but it's not expected - then it is most likely
                // somebody messing with the form on the client side, so we'll just consider it an empty field
                $postdata = Arr::isArray($this->fieldData[$row['field']]['postdata']) ? NULL : $this->fieldData[$row['field']]['postdata'];
            }
            // Is the rule a callback?
            $callback = $callable = FALSE;
            if (Util::isString($rule)) {
                if (Str::strpos($rule, 'callback_') === 0) {
                    $rule = substr($rule, 9);
                    $callback = TRUE;
                }
            } elseif (is_callable($rule)) {
                $callable = TRUE;
            } elseif (Arr::isArray($rule) && isset($rule[0], $rule[1]) && is_callable($rule[1])) {
                // We have a "named" callable, so save the name
                $callable = $rule[0];
                $rule = $rule[1];
            }
            // Strip the parameter (if exists) from the rule
            // Rules can contain a parameter: max_length[5]
            $param = FALSE;
            if (! $callable && preg_match('/(.*?)\[(.*)\]/', $rule, $match)) {
                $rule = $match[1];
                $param = $match[2];
            }
            // Call the function that corresponds to the rule
            if ($callback or $callable !== FALSE) {
                if ($callback) {
                    if (! method_exists(self::getInstances(), $rule)) {
                        // log_message('debug', 'Unable to find callback validation rule: ' . $rule);
                        $result = FALSE;
                    } else {
                        // Run the function and grab the result
                        $result = self::getInstances()->$rule($postdata, $param);
                    }
                } else {
                    $result = Arr::isArray($rule) ? $rule[0]->{$rule[1]}($postdata) : $rule($postdata);
                    
                    // Is $callable set to a rule name?
                    if ($callable !== FALSE) {
                        $rule = $callable;
                    }
                }
                // Re-assign the result to the master data array
                if ($_in_array === TRUE) {
                    $this->fieldData[$row['field']]['postdata'][$cycles] = is_bool($result) ? $postdata : $result;
                } else {
                    $this->fieldData[$row['field']]['postdata'] = is_bool($result) ? $postdata : $result;
                }
                // If the field isn't required and we just processed a callback we'll move on...
                if (! Arr::inArray('required', $rules, TRUE) && $result !== FALSE) {
                    continue;
                }
            } elseif (! method_exists($this, $rule)) {
                // If our own wrapper function doesn't exist we see if a native PHP function does.
                // Users can use any native PHP function call that has one param.
                if (function_exists($rule)) {
                    // Native PHP functions issue warnings if you pass them more parameters than they use
                    $result = ($param !== FALSE) ? $rule($postdata, $param) : $rule($postdata);
                    if ($_in_array === TRUE) {
                        $this->fieldData[$row['field']]['postdata'][$cycles] = is_bool($result) ? $postdata : $result;
                    } else {
                        $this->fieldData[$row['field']]['postdata'] = is_bool($result) ? $postdata : $result;
                    }
                } else {
                    log_message('debug', 'Unable to find validation rule: ' . $rule);
                    $result = FALSE;
                }
            } else {
                $result = $this->$rule($postdata, $param);
                if ($_in_array === TRUE) {
                    $this->fieldData[$row['field']]['postdata'][$cycles] = is_bool($result) ? $postdata : $result;
                } else {
                    $this->fieldData[$row['field']]['postdata'] = is_bool($result) ? $postdata : $result;
                }
            }
            // Did the rule test negatively? If so, grab the error.
            if ($result === FALSE) {
                // Callable rules might not have named error messages
                if (! Util::isString($rule)) {
                    return;
                }
                // Check if a custom message is defined
                if (isset($this->fieldData[$row['field']]['errors'][$rule])) {
                    $line = $this->fieldData[$row['field']]['errors'][$rule];
                } elseif (! isset($this->errorMessages[$rule])) {
                    if (FALSE === ($line = Lang::text('VALIDATION_'.$rule)) && FALSE === ($line = Lang::text('VALIDATION_'.$rule))) {
                        $line = $this->CI->lang->line('form_validation_error_message_not_set') . '(' . $rule . ')';
                    }
                } else {
                    $line = $this->errorMessages[$rule];
                }
                // Is the parameter we are inserting into the error message the name
                // of another field? If so we need to grab its "field label"
                if (isset($this->fieldData[$param], $this->fieldData[$param]['label'])) {
                    $param = $this->traslateField($this->fieldData[$param]['label']);
                }
                // Build the error message
                $message = $this->buildError($line, $this->traslateField($row['label']), $param);
                // Save the error message
                $this->fieldData[$row['field']]['error'] = $message;
                if (! isset($this->errorArray[$row['field']])) {
                    $this->errorArray[$row['field']] = $message;
                }
                return;
            }
        }
    }
    
    /**
     * 
     * @tutorial    {Re-populate the _POST array with our finalized and processed data}	
     * @author 		{Rodolfo Perez ~ pipo6280@gmail.com}
     * @since 		{27/08/2015}
     * @return      void
     */
    protected function reset()
    {
        foreach ($this->fieldData as $field => $row) {
            if ($row['postdata'] === NULL) {
                continue;
            }
            if ($row['is_array'] === FALSE) {
                if (isset($_POST[$row['field']])) {
                    $_POST[$row['field']] = $row['postdata'];
                }
            } else {
                // start with a reference
                $post_ref = & $_POST;
                // before we assign values, make a reference to the right POST key
                if (Arr::count($row['keys']) === 1) {
                    $post_ref = & $post_ref[current($row['keys'])];
                } else {
                    foreach ($row['keys'] as $val) {
                        $post_ref = & $post_ref[$val];
                    }
                }
                if (Arr::isArray($row['postdata'])) {
                    $array = array();
                    foreach ($row['postdata'] as $k => $v) {
                        $array[$k] = $v;
                    }
                    $post_ref = $array;
                } else {
                    $post_ref = $row['postdata'];
                }
            }
        }
    }
    
    /**
     * 
     * @tutorial    {Traverse a multidimensional $_POST array index until the data is found}	
     * @author 		{Rodolfo Perez ~ pipo6280@gmail.com}
     * @since 		{27/08/2015}
     * @param       array $array
     * @param       string $keys
     * @param       number $i
     * @return      Ambigous <NULL, unknown>
     */
    protected function reduceArray($array, $keys, $i = 0)
    {
        if (Arr::isArray($array) && isset($keys[$i])) {
            return isset($array[$keys[$i]]) ? $this->reduceArray($array[$keys[$i]], $keys, ($i + 1)) : NULL;
        }
        // NULL must be returned for empty fields
        return ($array === '') ? NULL : $array;
    }
    
    /**
     * 
     * @tutorial	{Build an error message using the field and param.}
     * @author 		{Rodolfo Perez ~ pipo6280@gmail.com}
     * @since 		{27/08/2015}
     * @param       string $line
     * @param       string $field
     * @param       string $param
     * @return      string|mixed
     */
    protected function buildError($line, $field = '', $param = '')
    {
        // Check for %s in the string for legacy support.
        if (Str::strpos($line, '%s') !== FALSE) {
            return sprintf($line, $field, $param);
        }
        return Str::strReplace(array(
            '{field}',
            '{param}'
        ), array(
            $field,
            $param
        ), $line);
    }
    
    /**
     * 
     * @tutorial	{Translate a field name}
     * @author 		{Rodolfo Perez ~ pipo6280@gmail.com}
     * @since  		{27/08/2015}
     * @param       string $fieldname
     * @return      string
     */
    protected function traslateField($fieldname)
    {
        // Do we need to translate the field name? We look for the prefix lang: to determine this
        if (sscanf($fieldname, 'lang:%s', $line) === 1) {
            // Were we able to translate the field name? If not we use $line
            if (FALSE === ($fieldname = $this->CI->lang->line('form_validation_' . $line)) && 
            // DEPRECATED support for non-prefixed keys
            FALSE === ($fieldname = $this->CI->lang->line($line, FALSE))) {
                return $line;
            }
        }
        return $fieldname;
    }
    
    /**
     * (non-PHPdoc)
     * @tutorial    {Set Message}
     * @author 		{Rodolfo Perez ~ pipo6280@gmail.com}
     * @since 		{26/08/2015}
     * @param       string $lang
     * @param       string $val
     * @return      mixed
     * @see         \system\Contracts\Validation\Validator::message()
     */
    public function message($lang, $val = '')
    {
        if (! Arr::isArray($lang)) {
            $lang = array(
                $lang => $val
            );
        }
        $this->errorMessages = Arr::arrayMerge($this->errorMessages, $lang);
        return $this;
    }
    
    /**
     * (non-PHPdoc)
     * @tutorial    {Set Error Message}
     * @author 		{Rodolfo Perez ~ pipo6280@gmail.com}
     * @since 		{26/08/2015}
     * @param unknown $lang
     * @param string $val
     * @see \system\Contracts\Validation\Validator::messageError()
     */
    public function messageError($lang, $val = '')
    {
        if (! Arr::isArray($lang)) {
            $lang = array(
                $lang => $val
            );
        }
        $this->errorArray = Arr::arrayMerge($this->errorArray, $lang);
        return $this;
    }
    
    /**
     * (non-PHPdoc)
     * @tutorial    {Gets the error message associated with a particular field}
     * @author 		Rodolfo Perez ~ pipo6280@gmail.com
     * @since 		26/08/2015
     * @param       unknown $field
     * @param       string $prefix
     * @param       string $suffix
     * @see         \system\Contracts\Validation\Validator::error()
     */
    public function error($field, $prefix = '', $suffix = '')
    {
        if (empty($this->fieldData[$field]['error'])) {
            return '';
        }
        if ($prefix === '') {
            $prefix = $this->errorPrefix;
        }
        if ($suffix === '') {
            $suffix = $this->errorSuffix;
        }
        return $prefix . $this->fieldData[$field]['error'] . $suffix;
    }
    
    /**
     * (non-PHPdoc)
     * @tutorial    {Returns the error messages as a string, wrapped in the error delimiters}
     * @author 		{Rodolfo Perez ~ pipo6280@gmail.com}
     * @since  		{28/08/2015}
     * @param       string $prefix
     * @param       string $suffix
     * @return      string
     * @see         \system\Contracts\Validation\Validator::errorString()
     */
    public function errorString($prefix = '', $suffix = '')
    {
        // No errors, validation passes!
        if (Arr::count($this->errorArray) === 0) {
            return '';
        }
        if ($prefix === '') {
            $prefix = $this->errorPrefix;
        }
        if ($suffix === '') {
            $suffix = $this->errorSuffix;
        }
        // Generate the error string
        $str = '<ul>';
        foreach ($this->errorArray as $val) {
            if ($val != '') {
                $str .= '<li>' . $val . "</li>";
            }
        }
        $str .= '</ul>';
        return $str;
    }
    
	/**
     * (non-PHPdoc)
     * @tutorial    {Required}
     * @author 		Rodolfo Perez ~ pipo6280@gmail.com
     * @since  		27/08/2015
     * @param       string $str
     * @see         \system\Contracts\Validation\Validator::required()
     */
    public function required($str)
    {
        return Arr::isArray($str) ? (bool) Arr::count($str) : (Util::trim($str) !== '');
    }
	/**
     * (non-PHPdoc)
     * @tutorial	{Performs a Regular Expression match test.}
     * @author 		Rodolfo Perez ~ pipo6280@gmail.com
     * @since  		28/08/2015
     * @param       string $str
     * @param       string $regex
     * @return      bool
     * @see         \system\Contracts\Validation\Validator::regex_match()
     */
    public function regex_match($str, $regex)
    {
        return (bool) preg_match($regex, $str);
    }

	/**
     * (non-PHPdoc)
     * @tutorial	{Match one field to another}
     * @author 		Rodolfo Perez ~ pipo6280@gmail.com
     * @since  		28/08/2015
     * @param       string $str
     * @param       string $field
     * @return      bool
     * @see         \system\Contracts\Validation\Validator::matches()
     */
    public function matches($str, $field)
    {
        return isset($this->fieldData[$field], $this->fieldData[$field]['postdata']) ? ($str === $this->fieldData[$field]['postdata']) : FALSE;
    }

	/**
     * (non-PHPdoc)
     * @tutorial	{Differs from another field}
     * @author 		{Rodolfo Perez ~ pipo6280@gmail.com}
     * @since  		{28/08/2015}
     * @param       string $str
     * @param       string $field
     * @return      bool
     * @see         \system\Contracts\Validation\Validator::differs()
     */
    public function differs($str, $field)
    {
        return ! (isset($this->_field_data[$field]) && $this->_field_data[$field]['postdata'] === $str);
    }

	/**
     * (non-PHPdoc)
     * @tutorial	{Is Unique, check if the input value doesn't already exist in the specified database field.}
     * @author 		{Rodolfo Perez ~ pipo6280@gmail.com}
     * @since  		{28/08/2015}
     * @param       string $str
     * @param       string $field
     * @see \system\Contracts\Validation\Validator::is_unique()
     */
    public function is_unique($str, $field)
    {
        sscanf($field, '%[^.].%[^.]', $table, $field);
        return isset($this->CI->db) ? ($this->CI->db->limit(1)->get_where($table, array( $field => $str ))->num_rows() === 0) : FALSE;
    }

	/**
     * (non-PHPdoc)
     * @tutorial	{Min length}
     * @author 		{Rodolfo Perez ~ pipo6280@gmail.com}
     * @since  		{28/08/2015}
     * @param       string $str
     * @param       string $val
     * @return      bool
     * @see         \system\Contracts\Validation\Validator::min_length()
     */
    public function min_length($str, $val)
    {
        if (! is_numeric($val)) {
            return FALSE;
        }
        return ($val <= mb_strlen($str));
    }

	/**
     * (non-PHPdoc)
     * @tutorial	{Max length}
     * @author 		{Rodolfo Perez ~ pipo6280@gmail.com}
     * @since  		{28/08/2015}
     * @param       string $str
     * @param       string $val
     * @return      bool
     * @see         \system\Contracts\Validation\Validator::max_length()
     */
    public function max_length($str, $val)
    {
        if (! is_numeric($val)) {
            return FALSE;
        }
        return ($val >= mb_strlen($str));
    }

	/**
     * (non-PHPdoc)
     * @tutorial	{Exact length}
     * @author 		{Rodolfo Perez ~ pipo6280@gmail.com}
     * @since  		{28/08/2015}
     * @param       string $str
     * @param       string $val
     * @see         \system\Contracts\Validation\Validator::exact_length()
     */
    public function exact_length($str, $val)
    {
        if (! is_numeric($val)) {
            return FALSE;
        }
        return (mb_strlen($str) === (int) $val);
    }
	/**
     * (non-PHPdoc)
     * @tutorial	{Valid URL}
     * @author 		{Rodolfo Perez ~ pipo6280@gmail.com}
     * @since  		{28/08/2015}
     * @param       string $str
     * @see         \system\Contracts\Validation\Validator::valid_url()
     */
    public function valid_url($str = '')
    {
        if (empty($str)) {
            return FALSE;
        } elseif (preg_match('/^(?:([^:]*)\:)?\/\/(.+)$/', $str, $matches)) {
            if (empty($matches[2])) {
                return FALSE;
            } elseif (! Arr::inArray($matches[1], array(
                'http',
                'https'
            ), TRUE)) {
                return FALSE;
            }
            $str = $matches[2];
        }
        $str = 'http://' . $str;
        // There's a bug affecting PHP 5.2.13, 5.3.2 that considers the
        // underscore to be a valid hostname character instead of a dash.
        // Reference: https://bugs.php.net/bug.php?id=51192
        if (version_compare(PHP_VERSION, '5.2.13', '==') or version_compare(PHP_VERSION, '5.3.2', '==')) {
            sscanf($str, 'http://%[^/]', $host);
            $str = substr_replace($str, strtr($host, array(
                '_' => '-',
                '-' => '_'
            )), 7, strlen($host));
        }
        return (filter_var($str, FILTER_VALIDATE_URL) !== FALSE);
    }

	/**
     * (non-PHPdoc)
     * @tutorial	{Valid Email}
     * @author 		{Rodolfo Perez ~ pipo6280@gmail.com}
     * @since  		{28/08/2015}
     * @param       string $str
     * @see         \system\Contracts\Validation\Validator::valid_email()
     */
    public function valid_email($str = '')
    {
        if (function_exists('idn_to_ascii') && $atpos = strpos($str, '@')) {
            $str = substr($str, 0, ++ $atpos) . idn_to_ascii(substr($str, $atpos));
        }
        return (bool) filter_var($str, FILTER_VALIDATE_EMAIL);
    }

	/**
     * (non-PHPdoc)
     * @tutorial	{}
     * @author 		{Rodolfo Perez ~ pipo6280@gmail.com}
     * @since  		{28/08/2015}
     * @param       string $str
     * @see         \system\Contracts\Validation\Validator::valid_emails()
     */
    public function valid_emails($str = '')
    {
        if (Str::strpos($str, ',') === FALSE) {
            return $this->valid_email(Util::trim($str));
        }
        foreach (Arr::explode($str, ',') as $email) {
            if (Util::trim($email) !== '' && $this->valid_email(Util::trim($email)) === FALSE) {
                return FALSE;
            }
        }
        return TRUE;
    }

	/**
     * (non-PHPdoc)
     * @tutorial	
     * @author 		{Rodolfo Perez ~ pipo6280@gmail.com}
     * @since  		{28/08/2015}
     * @param       string $ip
     * @param       string $which
     * @see \system\Contracts\Validation\Validator::valid_ip()
     */
    public function valid_ip($ip = NULL, $which = '')
    {
        // TODO Auto-generated method stub
        
    }

	/**
     * (non-PHPdoc)
     * @tutorial	
     * @author 		{Rodolfo Perez ~ pipo6280@gmail.com}
     * @since  		{28/08/2015}
     * @param string $str
     * @see \system\Contracts\Validation\Validator::alpha()
     */
    public function alpha($str = '')
    {
        // TODO Auto-generated method stub
        
    }

	/**
     * (non-PHPdoc)
     * @tutorial	
     * @author 		{Rodolfo Perez ~ pipo6280@gmail.com}
     * @since  		{28/08/2015}
     * @param       string $str
     * @see         \system\Contracts\Validation\Validator::alpha_numeric()
     */
    public function alpha_numeric($str = '')
    {
        // TODO Auto-generated method stub
        
    }
}
