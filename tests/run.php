#!/usr/bin/env php
<?php

/**
 * SIMPEL-Alkhairaat Test Runner
 * 
 * Usage: php tests/run.php
 */

define('BASE_PATH', dirname(__DIR__));

require_once BASE_PATH . '/helpers/autoloader.php';
require_once BASE_PATH . '/helpers/bootstrap.php';

use App\Tests\ValidationTest;
use App\Tests\FilterTest;

echo "\n" . str_repeat('=', 60) . "\n";
echo "SIMPEL-Alkhairaat Test Suite\n";
echo str_repeat('=', 60) . "\n\n";

// Run Validation Tests
echo "\n[1] Running Validation Tests...\n";
echo str_repeat('-', 60) . "\n";
$validationTest = new ValidationTest();
$validationTest->testRequiredValidation();
$validationTest->testEmailValidation();
$validationTest->testNumericValidation();
$validationTest->testMinLengthValidation();
$validationTest->testValidData();

$validationResults = $validationTest->getResults();
echo implode("\n", $validationResults['tests']) . "\n";
echo "\nValidation Tests: {$validationResults['passed']} passed, {$validationResults['failed']} failed\n";

// Run Filter Tests
echo "\n[2] Running Filter Tests...\n";
echo str_repeat('-', 60) . "\n";
$filterTest = new FilterTest();
$filterTest->testFilterWhere();
$filterTest->testFilterSearch();
$filterTest->testFilterOrderBy();
$filterTest->testFilterPagination();

$filterResults = $filterTest->getResults();
echo implode("\n", $filterResults['tests']) . "\n";
echo "\nFilter Tests: {$filterResults['passed']} passed, {$filterResults['failed']} failed\n";

// Summary
$totalPassed = $validationResults['passed'] + $filterResults['passed'];
$totalFailed = $validationResults['failed'] + $filterResults['failed'];
$total = $totalPassed + $totalFailed;

echo "\n" . str_repeat('=', 60) . "\n";
echo "Test Summary\n";
echo str_repeat('=', 60) . "\n";
echo "Total Tests: $total\n";
echo "Passed: $totalPassed\n";
echo "Failed: $totalFailed\n";
echo "Success Rate: " . number_format(($totalPassed / $total) * 100, 2) . "%\n";
echo str_repeat('=', 60) . "\n\n";

exit($totalFailed > 0 ? 1 : 0);
