String.prototype.trim = function(chars) {
	return this.ltrim(chars).rtrim(chars);
}

String.prototype.ltrim = function(chars) {
	return this.replace(new RegExp("^[" + chars + "]+", "g"),"");
}

String.prototype.rtrim = function(chars) {
	return this.replace(new RegExp("[" + chars + "]+$", "g"),"");
}

jQuery.fn.extend({
		convert_number: function() {
			return this.each( function() {
				var txt = document.getElementById(this.id).innerText;
				var txt = document.getElementById(this.id).innerHTML;

				var ar_item = new Array('0','1', '2','3','4','5','6','7','8','9');
				var ar_replace = new Array('&#1776;','&#1777;', '&#1778;','&#1779;','&#1780;','&#1781;','&#1782;','&#1783;','&#1784;','&#1785;');

				var result = new Array();
				for(var i = 0; i < txt.length; i++) {
					result.push(txt.charAt(i));
				}

				for(var i = 0; i < result.length; i++) {
					for(var j = 0; j < ar_item.length; j++) {
						if(result[i] == ar_item[j]) {
							result[i] = ar_replace[j];
						}
					}
				}

				txt = "";
				for(var i = 0; i < result.length; i++) {
					txt += result[i];
				}

				document.getElementById(this.id).innerText = txt;
				document.getElementById(this.id).innerHTML = txt;
			});
		}
	}
);

var farsiLanguage = true;

function myF(myField,e)
{
    e = (e) ? e : event;
	var charCode = (e.charCode) ? e.charCode : ((e.which) ? e.which : e.keyCode);
	var key = charCode;
    if(key == 119)
    {farsiLanguage =(farsiLanguage==true) ? false : true ;}
}

function FarsiType(myField,e)
{
	if(myField.id == "team_name") {
	    var len = $("#team_name").val().length;
	    if(len > 13) {
	        return null;
	    }
	}
	else if(myField.id == "name") {
	    var len = $("#name").val().length;
	    if(len > 13) {
	        return null;
	    }
	}
	e = (e) ? e : event;
	var charCode = (e.charCode) ? e.charCode : ((e.which) ? e.which : e.keyCode);
	var key = charCode;
	var FarsiType =
	{
		farsiKey : [
			32    , 33    , 34    , 35    , 36    , 37    , 1548  , 1711  ,
			41    , 40    , 215   , 43    , 1608  , 45    , 46    , 47    ,
			48    , 49    , 50    , 51    , 52    , 53    , 54    , 55    ,
			56    , 57    , 58    , 1705  , 44    , 61    , 46    , 1567  ,
			64    , 1616  , 1584  , 125   , 1609  , 1615  , 1609  , 1604  ,
			1570  , 247   , 1600  , 1548  , 47    , 8217  , 1583  , 215   ,
			1563  , 1614  , 1569  , 1613  , 1601  , 8216  , 123   , 1611  ,
			1618  , 1573  , 126   , 1580  , 1688  , 1670  , 94    , 95    ,
			1662  , 1588  , 1584  , 1586  , 1740  , 1579  , 1576  , 1604  ,
			1575  , 1607  , 1578  , 1606  , 1605  , 1574  , 1583  , 1582  ,
			1581  , 1590  , 1602  , 1587  , 1601  , 1593  , 1585  , 1589  ,
			1591  , 1594  , 1592  , 60    , 124   , 62    , 1617
		]
	}
	try
	{
		if(farsiLanguage)
		{
		    if (key != 46 && key < 1000 && key != 32 && key != 8 && key != 13 && key != 9)
		    {
				key = FarsiType.farsiKey[key-32];
				myField.value+=String.fromCharCode(key);
				return false;
		    }
		}
		return true;
	}
	catch(error)
	{alert(error);}
	return true;
}