<?php

require 'vendor/autoload.php';

date_default_timezone_set("Asia/Taipei");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $mode = $_POST['mode'];

    if ($mode == 'send') {
        // 設置基本參數
        $client = new \Google_Client();
        $client->setApplicationName('haoquan');
        $client->setScopes([\Google_Service_Sheets::SPREADSHEETS]);
        $client->setAccessType('offline');
        $client->setAuthConfig('AUTH_FILE_LOCATION'); // AUTH 檔案位置
        $service = new Google_Service_Sheets($client);
        $spreadsheetId = "SPREAD_SHEET_ID"; // 試算表 ID

        // 取得 POST 傳來的資料
        $userId = $_POST['userId'] ? $_POST['userId'] : '無資料';
        $userName = $_POST['userName'] ? $_POST['userName'] : '無資料';
        $lanway1 = $_POST['lanway1'] ? $_POST['lanway1'] : '無資料';
        $lanway2 = $_POST['lanway2'] ? $_POST['lanway2'] : '無資料';
        $lanway3 = $_POST['lanway3'] ? $_POST['lanway3'] : '無資料';

        // 取得 IP 位址
        if (!empty($_SERVER["HTTP_CLIENT_IP"])) {
            $ip = $_SERVER["HTTP_CLIENT_IP"];
        } elseif (!empty($_SERVER["HTTP_X_FORWARDED_FOR"])) {
            $ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
        } else {
            $ip = $_SERVER["REMOTE_ADDR"];
        }

        $info = array();
        array_push($info, $userId, $userName, $lanway1, $lanway2, $lanway3, $ip, date("Y-m-d H:i:s"));

        $range = "first"; // 試算表名稱
        $values = [
            $info
        ];
        $body = new Google_Service_Sheets_ValueRange([
            "values" => $values
        ]);
        $params = [
            "valueInputOption" => "RAW"
        ];
        $insert = [
            "insertDataOption" => "INSERT_ROWS"
        ];
        $result = $service->spreadsheets_values->append(
            $spreadsheetId,
            $range,
            $body,
            $params,
            $insert
        );
        echo "[" . $userName . "] 成功發送";

    } else if ($mode == 'get') {
        // 設置基本參數
        $client = new \Google_Client();
        $client->setApplicationName('haoquan');
        $client->setScopes([\Google_Service_Sheets::SPREADSHEETS]);
        $client->setAccessType('offline');
        $client->setAuthConfig('AUTH_FILE_LOCATION'); // AUTH 檔案位置
        $service = new Google_Service_Sheets($client);
        $spreadsheetId = "SPREAD_SHEET_ID"; // 試算表 ID

        $range = "first"; // 試算表名稱
        $result = $service->spreadsheets_values->get($spreadsheetId, $range);
        $values = $result->getValues();
        $numRows = $values != null ? count($values) : 0;
        $datas = array($numRows, $values);
        
        echo json_encode($datas, JSON_UNESCAPED_UNICODE);
    }
}
