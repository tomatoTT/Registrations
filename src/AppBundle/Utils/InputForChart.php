<?php
namespace AppBundle\Utils;

class InputForChart {
    static function getInput() {
        $postSize = \sizeof($_POST);
        $filters = array(
                "regYearMin" => array('filter' => FILTER_SANITIZE_NUMBER_INT),
                "regYearMax" => array('filter' => FILTER_SANITIZE_NUMBER_INT),
                "regMonthMin" => array('filter' => FILTER_SANITIZE_NUMBER_INT),
                "regMonthMax" => array('filter' => FILTER_SANITIZE_NUMBER_INT),
                "make" => array('filter' => FILTER_SANITIZE_FULL_SPECIAL_CHARS)
            );
        if ($postSize > 5) {
            for ($i = 5; $i<$postSize; $i++) {
                $filters["county".($i-5)] = array('filter' => FILTER_SANITIZE_STRING);
            }
        }
        $myPost = filter_input_array(INPUT_POST, $filters);
        $conditions = [
            "regYearMin" => $myPost['regYearMin'],
            "regMonthMin" => $myPost['regMonthMin'],
            "regYearMax" => $myPost['regYearMax'],
            "regMonthMax" => $myPost['regMonthMax'],
            "make" => $myPost['make']
        ];
        if ($postSize > 5) {
            for ($i = 5; $i<$postSize; $i++) {
                $conditions["county".($i-5)] = $myPost["county" . ($i-5)];
            }
        }
        return $conditions;
    }
}