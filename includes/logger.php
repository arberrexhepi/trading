<?php

function logError($message) {
    error_log("[Preferences API] " . $message);
}
