<?php

require_once __DIR__ . '/../../app/Testes/UserControllerTest.php';

$test = new UserControllerTest();
$test->testCreateUserValidData();
$test->testUpdateUserValidData();

// Exibir resultados
echo "All tests executed.\n";
