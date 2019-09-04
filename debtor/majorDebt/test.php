<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>ระบบลงทะเบียนผู้ใช้งาน</title>
<script src="https://d.line-scdn.net/liff/1.0/sdk.js"></script>
<script src="lib/jquery-3.3.1.min.js"></script>
<script src="lib/bootstrap.min.js"></script>
<link href="lib/bootstrap.min.css" rel="stylesheet" />
<script>
//init LIFF
function initializeApp(data) {
let urlParams = new URLSearchParams(window.location.search);
$('#name').val(urlParams.toString());
$('#userid').val(data.context.userId);

$('#UserInfo').val(profile.displayName);
}
//ready
$(function () {
//init LIFF
liff.init(function (data) {
initializeApp(data);
});
//ButtonGetProfile
$('#ButtonGetProfile').click(function () {
liff.getProfile().then(
profile=> {
$('#UserInfo').val(profile.displayName);
alert('done');
}
);
});
//ButtonSendMsg #QueryString
$('#ButtonSendMsg').click(function () {
liff.sendMessages([
{
type: 'text',
// text: $('#userid').val() + $('#QueryString').val() + $('#msg').val()
text: $('คุณเคยลงทะเบียนแล้ว').val()
}
])
.then(() => {
alert('done');
})
});
});
</script>
</head>
<body>
<form action="save.php" method="get">
<div class="row">
<div class="col-md-6" style="margin:5px">
<input class="form-control" type="text" id="userid" name="userid" /> <br />
<label>ชื่อนามสกุล</label>
<input class="form-control" type="text" id="UserInfo" name="UserInfo"/><br />
<label>สำนัก:</label>
<input class="form-control" type="text" id="samnak" name="samnak" /><br />
<! — <button class="btn btn-primary" id="ButtonSendMsg" >ลงทะเบียน</button> →
<button class="btn btn-primary" >ลงทะเบียน</button>
</div>
</div>
</form>
</body>
</html>