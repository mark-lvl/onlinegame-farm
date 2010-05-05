

(function($) {
	$.fn.validationEngineLanguage = function() {};
	$.validationEngineLanguage = {
		newLang: function() {
			$.validationEngineLanguage.allRules = 	{"required":{    			// Add your regex rules here, you can take telephone as an example
						"regex":"none",
						"alertText":"* پر کردن این فیلد ضروریست",
						"alertTextCheckboxMultiple":"* یکی را انتخاب کنید",
						"alertTextCheckboxe":"* تیک بزنید"},
					"length":{
						"regex":"none",
						"alertText":"*مابین ",
						"alertText2":" تا ",
						"alertText3": "حرف پذیرفته است"},
					"maxCheckbox":{
						"regex":"none",
						"alertText":"* Checks allowed Exceeded"},	
					"minCheckbox":{
						"regex":"none",
						"alertText":"* Please select ",
						"alertText2":" options"},	
					"confirm":{
						"regex":"none",
						"alertText":"* ورودی شما صحیح نمیباشد"},		
					"telephone":{
						"regex":"/^[0-9\-\(\)\ ]+$/",
						"alertText":"* Invalid phone number"},	
					"email":{
						"regex":"/^[a-zA-Z0-9_\.\-]+\@([a-zA-Z0-9\-]+\.)+[a-zA-Z0-9]{2,4}$/",
						"alertText":"* آدرس ایمیل را اشتباه وارد کردی"},	
					"date":{
                         "regex":"/^[0-9]{4}\-\[0-9]{1,2}\-\[0-9]{1,2}$/",
                         "alertText":"* Invalid date, must be in YYYY-MM-DD format"},
					"onlyNumber":{
						"regex":"/^[0-9\ ]+$/",
						"alertText":"* فقط اعداد"},	
					"noSpecialCaracters":{
						"regex":"/^[0-9a-zA-Z]+$/",
						"alertText":"* ورود کاراکترهای خاص مجاز نیست"},	
					"ajaxUser":{
						"file":"validateUser.php",
						"extraData":"name=eric",
						"alertTextOk":"* This user is available",	
						"alertTextLoad":"* Loading, please wait",
						"alertText":"* This user is already taken"},	
					"validateDay":{
						"nname":"validateDay",
						"alertText":"روز بین 1 تا 31"},
					"validateMonth":{
						"nname":"validateMonth",
						"alertText":"ماه بین 1 تا 12"},
					"validateYear":{
						"nname":"validateYear",
						"alertText":"سال بین 1300 تا 1389"},
					"passwordLength":{
						"nname":"passwordLength",
						"alertText":"مابین 6 تا 12 کاراکتر"},
					"firstnameLength":{
						"nname":"firstnameLength",
						"alertText":"حداکثر 10 کاراکتر"},
					"lastnameLength":{
						"nname":"lastnameLength",
						"alertText":"حداکثر 18 کاراکتر"},
					"city":{
						"nname":"city",
						"alertText":"باید یکی رو انتخاب کنی"},
					"ajaxName":{
						"file":"validateUser.php",
						"alertText":"* This name is already taken",
						"alertTextOk":"* This name is available",	
						"alertTextLoad":"* Loading, please wait"},		
					"onlyLetter":{
						"regex":"/^[a-zA-Z\ \']+$/",
						"alertText":"* فقط حروف"}
		}
	}
        }
})(jQuery);

$(document).ready(function() {	
	$.validationEngineLanguage.newLang()
});
