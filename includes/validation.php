<?php

function validateSymbol($symbol) {
    return preg_match('/^[a-zA-Z0-9]{1,10}$/', $symbol);
}

function validateRiskLevel($riskLevel) {
    return filter_var($riskLevel, FILTER_VALIDATE_INT, [
        'options' => ['min_range' => 1, 'max_range' => 5]
    ]);
}

?>