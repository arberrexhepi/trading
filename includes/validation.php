<?php

function validateSymbol($symbol) {
    return preg_match('/^[A-Za-z0-9]{1,10}$/', $symbol);
}

function validateRiskLevel($riskLevel) {
    return is_numeric($riskLevel) && $riskLevel >= 1 && $riskLevel <= 5;
}

