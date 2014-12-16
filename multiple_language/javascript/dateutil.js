
/**
 * 日期时间字符串
 * 
 */
function dateTimeToInt(dateTimeStr) {
	var dateInt = 0;
	var dateStrs = null, ymd = null, hms = null;
	var datetime = new Date();
	if (dateTimeStr.indexOf(" ") != -1 && dateTimeStr.indexOf("-") != -1
			&& dateTimeStr.indexOf(":") != -1) { // 说明日期+时间
		dateStrs = dateTimeStr.split(" ");
		ymd = dateStrs[0].split("-");// 年月日
		hms = dateStrs[1].split(":");// 时分秒
		datetime.setYear(ymd[0]);
		datetime.setMonth(ymd[1] - 1);
		datetime.setDate(parseInt(ymd[2]));
		datetime.setHours(hms[0]);
		datetime.setMinutes(hms[1]);
		datetime.setSeconds(hms[2]);
		datetime.setMilliseconds(0);
	} else if (dateTimeStr.indexOf(" ") == -1 && dateTimeStr.indexOf("-") != -1
			&& dateTimeStr.indexOf(":") == -1) {
		dateStrs = dateTimeStr.split(" ");
		ymd = dateStrs[0].split("-");// 年月日
		datetime.setYear(ymd[0]);
		datetime.setMonth(ymd[1] - 1);
		datetime.setDate(parseInt(ymd[2]));
		datetime.setHours(0);
		datetime.setMinutes(0);
		datetime.setSeconds(0);
		datetime.setMilliseconds(0);
	}
	return parseInt(datetime.getTime() / 1000);
}

/**
 * int时间转成字符串 MM/dd/YY
 * 
 * @param intTime
 * @return string MM/dd/YY
 */
function intToDateTime(intTime) {
	var date = new Date(intTime * 1000);
	var m = format2wide(date.getMonth() + 1);
	var d = format2wide(date.getDate());
	var y = date.getFullYear();
	return y + '-' + m + '-' + d;
}

/**
 * int时间转成字符串 MM/dd/YY HH:mm:ss
 * 
 * @param intTime
 * @return string MM/dd/YY HH:mm:ss
 */
function intToDateTime2(intTime) {
	var date = new Date();
	date.setTime(intTime);
	// alert(date.toLocaleString());
	var MM = format2wide(date.getMonth() + 1);
	var dd = format2wide(date.getDate());
	var YY = date.getFullYear();
	var mm = format2wide(date.getMinutes());
	var HH = format2wide(date.getHours());
	var ss = format2wide(date.getSeconds());
	return MM + '/' + dd + '/' + YY + ' ' + HH + ':' + mm + ':' + ss;
}

function format2wide(i) {
	if (i < 10) {
		return "0".concat(i);
	}
	return i;
}

/**
 * 日期时间字符串
 * 
 */
function phpTimeToJSTime(dateTimeStr) {
	var dateInt = 0;
	var dateStrs = null, ymd = null, hms = null;
	var datetime = new Date();
	if (dateTimeStr.indexOf(" ") != -1 && dateTimeStr.indexOf("/") != -1
			&& dateTimeStr.indexOf(":") != -1) { // 说明日期+时间
		dateStrs = dateTimeStr.split(" ");
		ymd = dateStrs[0].split("/");// 年月日
		hms = dateStrs[1].split(":");// 时分秒
		datetime.setYear(ymd[2]);
		datetime.setMonth(ymd[0] - 1);
		datetime.setDate(parseInt(ymd[1]));
		datetime.setHours(hms[0]);
		datetime.setMinutes(hms[1]);
		datetime.setSeconds(hms[2]);
		datetime.setMilliseconds(0);
	} else if (dateTimeStr.indexOf(" ") == -1 && dateTimeStr.indexOf("/") != -1
			&& dateTimeStr.indexOf(":") == -1) {
		dateStrs = dateTimeStr.split(" ");
		ymd = dateStrs[0].split("/");// 年月日
		datetime.setYear(ymd[2]);
		datetime.setMonth(ymd[0] - 1);
		datetime.setDate(parseInt(ymd[1]));
		datetime.setHours(0);
		datetime.setMinutes(0);
		datetime.setSeconds(0);
		datetime.setMilliseconds(0);
	}
	return parseInt(datetime.getTime() / 1000);
}
