<?php
class Validator
{
    private $_errors = [];
    /**
     * Validate fields
     * @param array $src data to validate
     * @param array $rules attribules tu validate every data
     * @return empty
     */
    public function validate($src, $rules = [])
    {
        foreach ($src as $item => $item_value) {
            if (key_exists($item, $rules)) {
                foreach ($rules[$item] as $rule => $rule_value) {
                    if (is_int($rule))
                        $rule = $rule_value;
                    // echo '<pre>';
                    // print_r($item);
                    // echo ' - ';
                    // print_r($item_value);
                    // echo '</pre>';
                    switch ($rule) {
                        case 'required':
                            if (empty($item_value) && $rule_value) {
                                $this->addError($item, ucwords($item) . ' required');
                            }
                            break;

                        case 'minLen':
                            if (strlen($item_value) < $rule_value) {
                                $this->addError($item, ucwords($item) . ' should be minimum ' . $rule_value . ' characters');
                            }
                            break;

                        case 'maxLen':
                            if (strlen($item_value) > $rule_value) {
                                $this->addError($item, ucwords($item) . ' should be maximum ' . $rule_value . ' characters');
                            }
                            break;

                        case 'numeric':
                            if (!ctype_digit($item_value) && $rule_value) {
                                $this->addError($item, ucwords($item) . ' should be numeric');
                            }
                            break;
                        case 'alpha':
                            if (!ctype_alpha($item_value) && $rule_value) {
                                $this->addError($item, ucwords($item) . ' should be alphabetic characters');
                            }
                            break;
                        case 'email':
                            if (!filter_var($item_value, FILTER_VALIDATE_EMAIL)) {
                                $this->addError($item, ucwords($item) . ' invalid format');
                            }
                            break;
                        case 'username':
                            if (!preg_match("/(?=(?:.*\d){2})(?=(?:.*[A-Za-z]){4})^[A-Za-z\d]*$/", $item_value)) {
                                $this->addError($item, ucwords($item) . ' must contain at least 2 numbers and 4 letters');
                            }
                            break;
                        case 'password':
                            if (!preg_match("/^(?:(?=.*[A-Z])(?=.*[-]).*)$/", $item_value)) {
                                $this->addError($item, ucwords($item) . ' must contain at least one capital letter and one hyphen');
                            }
                            break;
                    }
                }
            }
        }
    }

    /**
     * add errors to show user
     * @param string $item Name of item to add
     * @param array $error Message to show by item
     * @return empty
     */
    public function addError($item, $error)
    {
        $this->_errors[$item][] = $error;
    }

    /**
     * return all errors added
     * @return array 
     */
    public function error()
    {
        if (empty($this->_errors)) return false;
        return $this->_errors;
    }
}
