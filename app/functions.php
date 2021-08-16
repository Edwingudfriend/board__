<?php
function e($text)
{
    return htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
}

function logout()
{
    // Initialize the session
    session_start();

    // Unset all of the session variables
    $_SESSION = array();

    // Destroy the session.
    session_destroy();

    // Redirect to login page
    echo '<META HTTP-EQUIV="Refresh" Content="0; URL= ' . BASE_URL . '">';
    exit;
}
