# survey-liff
English | [繁體中文](docs/README_zh-tw.md)
## About The Project
This is a LIFF application for surveying that utilizes Google Sheets for data storage.
### Built With
* Google Sheets API
* LIFF API
* jQuery
* Bootstrap
* Font Awesome
* Flaticon
### Project Directory Structure
```
survey-liff/
├── js/
│   └── liff.js
├── index.php
└── googleSheetsAPI.php
```
## Getting Started
Follow the instructions to set up the project locally.
### Prerequisites
* Apache
* PHP 7.2
* JavaScript ES6
### Installation
1. Clone the repo
   ```sh
   git clone https://github.com/hqn21/survey-liff.git
   ```
2. Install Google Client Library
   ```sh
   composer require google/apiclient:^2.0
   ```
3. Enter your LIFF Information in `js/liff.js`
   ```js
   const defaultLiffId = "LIFF_ID";
   ```
4. Enter your Google Client auth file location in `googleSheetsAPI.php`
   ```php
   $client->setAuthConfig('AUTH_FILE_LOCATION');
   ```
5. Enter your spreadsheet id in `googleSheetsAPI.php`
   ```php
   $spreadsheetId = "SPREAD_SHEET_ID";
   ```
6. Enter your spreadsheet name in `googleSheetsAPI.php`
   ```php
   $range = "first";
   ```
7. Set your application name in `googleSheetsAPI.php` (optional)
   ```php
   $client->setApplicationName('haoquan');
   ```
## License
Distributed under the MIT License. See [LICENSE](LICENSE) for more information.
## Contact
劉顥權 Haoquan Liu - [contact@haoquan.me](mailto:contact@haoquan.me)

Project Link: [https://github.com/hqn21/survey-liff/](https://github.com/hqn21/survey-liff/)
