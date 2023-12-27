<?php
include_once(__DIR__ . '/../config.php');
include_once(__DIR__ . '/../vendor/autoload.php');
require_once(__DIR__ . '/../classes.php');
require_once(__DIR__ . '/../utils.php');

use Firebase\JWT\JWT;

$payload = file_get_contents('php://input');

if (empty($payload)) {
	$response = new ApiResponse('Empty payload!', 400);
	echo json_encode($response);
	die();
}

$data = json_decode($payload);
$name = $data->name;
$phone = $data->phone;

$ggData = new GGSheetData(GG_API_KEY, GG_API_URL, GG_SPREADSHEET_ID, GG_SHEET_NAME, GG_SHEET_RANGE);
$entries = $ggData->getEntries([
	'Họ và tên' => $name,
	'Số điện thoại' => $phone
]);

if (empty($entries['entries'])) {
	$response = new ApiResponse('Entry not found!', 404);
	echo json_encode($response);
	die();
}

$entry = $entries['entries'][0];

$responsePayload = [
	'headers' => $entries['headers'],
	'entry' => $entry
];
$jwt = JWT::encode($responsePayload, GG_API_KEY, 'HS256');
$responsePayload['jwt'] = $jwt;

$response = new ApiResponse('Success');
$response->setData($responsePayload);
echo json_encode($response, JSON_UNESCAPED_UNICODE);
