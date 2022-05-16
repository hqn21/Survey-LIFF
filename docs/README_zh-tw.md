# survey-liff
[English](https://github.com/hqn21/survey-liff/blob/main/README.md) | 繁體中文
## 關於專案
此專案為一個以 Google Sheets 作資料儲存的問卷調查 LIFF 應用程式。
### 使用資源
* Google Sheets API
* LIFF API
* jQuery
* Bootstrap
* Font Awesome
* Flaticon
### 檔案結構
```
survey-liff/
├── js/
│   └── liff.js
├── index.php
└── googleSheetsAPI.php
```
## 開始部屬
跟隨指示以在本地端部屬此專案。
### 事先準備
* Apache
* PHP 7.2
* JavaScript ES6
### 安裝步驟
1. 複製此 repo
   ```sh
   git clone https://github.com/hqn21/survey-liff.git
   ```
2. 安裝 Google Client Library
   ```sh
   composer require google/apiclient:^2.0
   ```
3. 在 `js/liff.js` 中輸入您的 LIFF 資訊
   ```js
   const defaultLiffId = "LIFF_ID";
   ```
4. 在 `googleSheetsAPI.php` 中輸入您的 Google Client 授權檔案
   ```php
   $client->setAuthConfig('AUTH_FILE_LOCATION');
   ```
5. 在 `googleSheetsAPI.php` 中填入您的 spreadsheet id
   ```php
   $spreadsheetId = "SPREAD_SHEET_ID";
   ```
6. 在 `googleSheetsAPI.php` 中填入您的 spreadsheet name
   ```php
   $range = "first";
   ```
7. 在 `googleSheetsAPI.php` 中填入您的應用程式名稱（非必要）
   ```php
   $client->setApplicationName('haoquan');
   ```
## License
根據 MIT License 發布，查看 [LICENSE](https://github.com/hqn21/survey-liff/blob/main/LICENSE) 以獲得更多資訊。
## 聯絡我
劉顥權 Haoquan Liu - [contact@haoquan.me](mailto:contact@haoquan.me)

專案連結：[https://github.com/hqn21/survey-liff/](https://github.com/hqn21/survey-liff/)
