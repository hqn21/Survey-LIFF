<!DOCTYPE html>
<html lang="zh-TW">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>問卷調查：Google 試算表 API 測試</title>

  <!-- BootStrap -->
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <script src="js/bootstrap.bundle.min.js"></script>

  <!-- JQuery CDN -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

  <style>
    .bd-placeholder-img {
      font-size: 1.125rem;
      text-anchor: middle;
      -webkit-user-select: none;
      -moz-user-select: none;
      user-select: none;
    }

    @media (min-width: 768px) {
      .bd-placeholder-img-lg {
        font-size: 3.5rem;
      }
    }
  </style>

  <link href="signin.css" rel="stylesheet">

  <script>
    function closeNotice() {
      $("#noticeModal").modal("hide");
    }

    function getData() {
      $.ajax({
        type: "POST",
        url: "googleSheetsAPI.php",
        dataType: "json",
        data: {
          mode: "get"
        },
        success: function(data) {
          printData(data);
        }
      });
    }

    function printData(data) {
      var dataString = "";
      // 將資料一一合併
      for (var i = 1; i < data[0]; i++) {
        for (var k = 0; k < 7; k++) {
          if (k == 0) {
            dataString = dataString + "<tr><td class='text-nowrap'>" + data[1][i][k] + "</td>";
          } else if (k == 6) {
            dataString = dataString + "<td class='text-nowrap'>" + data[1][i][k] + "</td></tr>";
          } else {
            dataString = dataString + "<td class='text-nowrap'>" + data[1][i][k] + "</td>";
          }
        }
      }
      // 將資料印在 sheetsData 中
      $("#sheetsData").html(dataString);
    }

    function sendData() {
      var lanway3Value;
      // 尋找被勾選的選項
      for (var i = 1; i <= 3; i++) {
        if ($("#option" + i).prop("checked")) {
          lanway3Data = ["option" + i, $("#option" + i).val()];
          break;
        }
      }

      // 判斷表單是否填寫完整
      if ($("#lanway1").val().length > 0 && $("#lanway2").val() != "開啟選單" && $("#lanway2").val().length > 0 && lanway3Data[1].length > 0) {
        $.ajax({
          type: "POST",
          url: "googleSheetsAPI.php",
          data: {
            mode: "send",
            userId: $("#userId").val(),
            userName: $("#userName").val(),
            lanway1: $("#lanway1").val(),
            lanway2: $("#lanway2").val(),
            lanway3: lanway3Data[1]
          },
          success: function(data) {
            // 將資料顯示在控制台
            console.log(data);
            // 更新顯示在網站上的試算表資料
            getData();
            // 清除表單資料
            $("#lanway1").val("");
            $("#lanway2").val("");
            $("#" + lanway3Data[0]).prop("checked", false);
            // 顯示提醒視窗
            $('#noticeModal').modal("show");
          }
        });
      } else {
        // 顯示錯誤視窗
        $("#errorModal").modal("show");
      }
    }
  </script>
</head>

<body class="text-center">

  <input type="hidden" id="userId">
  <input type="hidden" id="userName">

  <main class="form-signin">

    <!-- surveyModal -->
    <div class="modal fade" id="surveyModal" tabindex="-1" aria-labelledby="surveyModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="surveyModalLabel">問卷調查</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body text-start">
            <form>
              <div class="row mb-3">
                <label for="lanway1" class="col-sm-2 col-form-label">欄位一</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" id="lanway1">
                </div>
              </div>
              <div class="row mb-3">
                <label for="lanway2" class="col-sm-2 col-form-label">欄位二</label>
                <div class="col-sm-10">
                  <select id="lanway2" class="form-select" aria-label="lanway2">
                    <option selected>開啟選單</option>
                    <option value="選項I">選項I</option>
                    <option value="選項II">選項II</option>
                    <option value="選項III">選項III</option>
                  </select>
                </div>
              </div>
              <fieldset class="row mb-3">
                <legend class="col-form-label col-sm-2 pt-0">欄位三</legend>
                <div class="col-sm-10">
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="lanway3" id="option1" value="選項A">
                    <label class="form-check-label" for="option1">
                      選項A
                    </label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="lanway3" id="option2" value="選項B">
                    <label class="form-check-label" for="option2">
                      選項B
                    </label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="lanway3" id="option3" value="選項C">
                    <label class="form-check-label" for="option3">
                      選項C
                    </label>
                  </div>
                </div>
              </fieldset>
            </form>
          </div>
          <div class="modal-footer">
            <button onclick="sendData()" id="sendMessage" type="button" class="btn btn-primary" data-bs-dismiss="modal">確認發送</button>
          </div>
        </div>
      </div>
    </div>

    <!-- errorModal -->
    <div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="errorModalLabel">問卷填寫不完整</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body text-start">
            請確認問卷是否填寫完整，確認後重新輸入即可正常發送。
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">關閉</button>
          </div>
        </div>
      </div>
    </div>

    <!-- noticeModal -->
    <div class="modal fade" id="noticeModal" tabindex="-1" aria-labelledby="noticeModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="noticeModalLabel">您已成功填寫問卷</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body text-start">
            如需查看試算表資料，請點擊下方按鈕查看。<br>
            ※ 資料更新會需要些許時間，如尚未更新請在等待後，點擊主頁面的試算表圖標查看資料。
          </div>
          <div class="modal-footer">
            <button onclick="closeNotice()" type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#dataModal">查看試算表</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">關閉</button>
          </div>
        </div>
      </div>
    </div>

    <!-- dataModal -->
    <div class="modal fade" id="dataModal" tabindex="-1" aria-labelledby="dataModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="dataModalLabel">試算表資料</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body text-start" style="position: relative; overflow-x: scroll; overflow-y: scroll; height: 300px">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th class="text-nowrap" scope="col">用戶編號</th>
                  <th class="text-nowrap" scope="col">用戶名稱</th>
                  <th class="text-nowrap" scope="col">欄位一</th>
                  <th class="text-nowrap" scope="col">欄位二</th>
                  <th class="text-nowrap" scope="col">欄位三</th>
                  <th class="text-nowrap" scope="col">IP位址</th>
                  <th class="text-nowrap" scope="col">發送時間</th>
                </tr>
              </thead>
              <tbody id="sheetsData" name="sheetsData">
              </tbody>
            </table>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">關閉</button>
          </div>
        </div>
      </div>
    </div>

    <img onclick="$('#dataModal').modal('show')" class="mb-4" src="google-sheets.svg" alt="" width="72" height="57">
    <h4 class="h4 mb-3 fw-normal">問卷調查</h4>
    <button onclick="$('#surveyModal').modal('show')" class="btn btn-primary mb-3 d-grid gap-2 col-10 mx-auto" type="button">開始填寫</button>
    <div class="form-text">點擊 Google 試算表圖示可查看試算表資料</div>
    <p class="mt-5 mb-3 text-muted">&copy; <a class="text-reset text-decoration-none" href="https://github.com/hqn21" target="_BLANK">Haoquan Liu</a></p>
  </main>

  <!-- LIFF Documents -->
  <script charset="utf-8" src="https://static.line-scdn.net/liff/edge/2/sdk.js"></script>
  <script src="js/liff.js"></script>
</body>

</html>