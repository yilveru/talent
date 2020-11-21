<?php
class Utils
{
    /**
     * logout session
     * @param boolean $redirect If need redirecto
     * @return boolean
     */
    public function logOut($redirect = true)
    {
        session_unset();
        session_destroy();
        session_start();
        session_regenerate_id(true);
        if ($redirect) {
            header('Location: /');
            exit;
        } else {
            return true;
        }
    }
    public function cleanInput($data)
    {
        $tama = strlen(stripslashes(htmlspecialchars($data)));
        $data = trim($data);
        if (preg_match("/(>|=|<+)/", $data) || is_int($data)) {
            header('Location: ./');
            exit;
        } else {
            return $data;
        }
    }
}
