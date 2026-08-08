<?php
// Quick inspection of SDGs API via HTTP
$url = 'http://localhost/_Projek/KKN/CintaMulya/index.php/api/sdgs';
$opts = ['http' => ['header' => "X-Requested-With: XMLHttpRequest\r\n", 'ignore_errors' => true]];
$ctx = stream_context_create($opts);
$response = @file_get_contents($url, false, $ctx);
echo "Status: " . $http_response_header[0] . "\n";
echo "Response: " . ($response ?: 'EMPTY/FAILED') . "\n";
