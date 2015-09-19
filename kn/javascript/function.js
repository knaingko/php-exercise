<!--
// JavaScript Document
var err_blank = "should not be blank!!";
var err_email = "should be email format!!";
var err_string = "should not be special character!!";
var err_time = "should be time format!!";
var err_date = "should be date format!!";

var reg_email = eval("/^([a-zA-Z0-9])+([.a-zA-Z0-9_-])*@([a-zA-Z0-9_-])+(.[a-zA-Z0-9_-]+)+[a-zA-Z0-9_-]$/");
var regexp_int = eval("/^[0-9]+$/");
var regexp_decimal = eval("/(^[0-9])+([.0-9])*$/");
var regexp_string = eval("/^[a-zA-Z0-9]+$/");
var regexp_time = eval("/^[0-9]{1,4}:[0-9]{1,2}:[0-9]{1,2}$/");
var regexp_date = eval("/^[0-9]{1,4}-[0-9]{1,2}-[0-9]{1,4}$/");

function pageOpen(page)
{
	window.open(page,"_self");
}

function check_blank(obj)
{
	if(obj.value == "")
	{
		alert(obj.alt + " " + err_blank);
		obj.focus();
		throw new Error();
	}
}

function check_email(obj)
{
	if(!obj.value.match(regexp_email)){
		alert("Invalid Email Format!");
		obj.focus();
		throw new Error();
	}	
}

function check_int(obj)
{
	if(!obj.value.match(regexp_int)){
		alert("Invalid Integer Format");
		obj.focus();
		throw new Error();
	}
}

function check_decimal(obj)
{
	if(!obj.value.match(regexp_decimal)){
		alert("Invalid Decimal Format");
		obj.focus();
		throw new Error();
	}
}

function check_string(obj)
{
	if(!obj.value.match(regexp_string)){
		alert("Invalid String Format");
		obj.focus();
		throw new Error();
	}
}

function check_date(objDate, InputFormat)
{
	dateValue = objDate.value;

	//Input Format DDMMYYYY, MMDDYYYY, YYYYMMDD

	if(dateValue.length == 0){
		alert('Invalid Date value!');
		objDate.focus();
		throw new Error();
	}

	var posDelimeter = 0;
	var splitDelimeter = '';
	
	//Find Delimeter
	posDelimeter = dateValue.search('/');
	if(posDelimeter>=0) splitDelimeter = '/'; 

	posDelimeter = dateValue.search('-');
	if(posDelimeter>=0)	splitDelimeter = '-'; 
	
	if(splitDelimeter==''){
		alert('Invalid Date Format!');
		objDate.focus();
		throw new Error();
	}
	
	var chkDate	 = dateValue.split(splitDelimeter);
	var dayValue, monthValue, yearValue
	switch(InputFormat)
	{
		case 'DDMMYYYY':
			dayValue = chkDate[0];
			monthValue = chkDate[1];
			yearValue = chkDate[2];
			break;
		case 'MMDDYYYY':
			dayValue = chkDate[1];
			monthValue = chkDate[0];
			yearValue = chkDate[2];
			break;
		case 'YYYYMMDD':
			dayValue = chkDate[2];
			monthValue = chkDate[1];
			yearValue = chkDate[0];
			break;
	} //End Defind date value

	//Day Checking between 1 .. 31
	checkDay(dayValue, monthValue, yearValue);
	
	// Month Checking < 12 and invalid
	checkMonth(monthValue);
	dateValue = new Date (eval("'" + yearValue +'/'+ monthValue +'/'+ dayValue + "'" ));
	if(((dateValue.getMonth()+1) - monthValue) != 0)
	{
		alert('Invalid Date Value!');
		objDate.focus();
		throw new Error();
	}
}

function checkMonth(month)
{
	if((Number(month)<0 || Number(month)>12)){
		alert("Invalid Month Format");
		obj.focus();
		throw new Error();
	}
}

function checkDay(day, month, year)
{
	
	if((Number(month+1)<0 || Number(month+1)>12))
	{
		var chkday = "'"+ year +'/'+ (Number(month)+1) +'/01' + "'" ;
	}
	else
	{
		var chkday = "'" + (Number(year) +1) +'/01/01' + "'";
	}
	chkday =new Date (eval(chkday))
	var endDay = new Date(chkday.valueOf() - 86400000);
	if(day>endDay.getDate()) throw new Error();
}

function dayDiff(bigDate, smallDate)
{
	//Input Date format must be YYYY/MM/DD
	return ((new Date(bigDate)-new Date(smallDate)) /86400000);
}

function getSec()
{
}

function check_time(obj)
{
	if(obj.value.match(regexp_time))
	{
		if(obj.value=='00:00:00' || obj.value=='000:00:00' || obj.value=='0000:00:00'){
			alert(obj.alt + " " + err_blank);
			obj.focus();
			throw new Error();
		}
	}else{
		alert(obj.alt + " " + err_time);
		obj.focus();
		throw new Error();
	}
}

function checkDate(obj) {
	var mo, day, yr;
	var entry = obj.value;
	var reLong = /\b\d{4}[\/-]\d{1,2}[\/-]\d{1,2}\b/;	 
	var valid = (reLong.test(entry));
	if(valid){
		var delimChar = (entry.indexOf("/") != -1) ? "/" : "-";
		var delim1 = entry.indexOf(delimChar);
		var delim2 = entry.lastIndexOf(delimChar);
		
		yr = parseInt(entry.substring(0, delim1), 10);
		mo = parseInt(entry.substring(delim1+1, delim2), 10);
		day = parseInt(entry.substring(delim2+1), 10);
		// handle two-digit year
		if (yr < 100) {
			var today = new Date( );
			var currCent = parseInt(today.getFullYear( ) / 100) * 100;
			var threshold = (today.getFullYear( ) + 15) - currCent;
			if (yr > threshold) {
				yr += currCent - 100;
			} else {
				yr += currCent;
			}
		}
		var testDate = new Date(yr, mo-1, day);
		if (testDate.getDate() == day) {
			if (testDate.getMonth() + 1 == mo) {
				if (testDate.getFullYear() != yr) {
					alert("There is a problem with the year entry.");
					obj.focus();
					throw new Error();						
				}
			} else {
				alert("There is a problem with the month entry.");
				obj.focus();
				throw new Error();					
			}
		} else {
			alert("There is a problem with the day entry.");
			obj.focus();
			throw new Error();				
		}
	} else {
		alert("Incorrect date format. Enter as yyyy-mm-dd.");
		obj.focus();
		throw new Error();
	}
//	return true;
}

function checkTime(obj)
{
	if(!obj.value.match(regexp_time))
	{
		alert(obj.alt + " " + err_time);
		obj.focus();
		throw new Error();
	}
}
//-->
