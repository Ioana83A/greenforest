cookieName="pag_scroll_about_us"
expdays=365

// An adaptation of Dorcht's cookie functions.

function setCookie(name, value, expires, path, domain, secure){
    if (!expires){expires = new Date()}
    document.cookie = name + "=" + escape(value) + 
    ((expires == null) ? "" : "; expires=" + expires.toGMTString()) +
    ((path == null) ? "" : "; path=" + path) +
    ((domain == null) ? "" : "; domain=" + domain) +
    ((secure == null) ? "" : "; secure")
}

function getCookie(name) {
    var arg = name + "="
    var alen = arg.length
    var clen = document.cookie.length
    var i = 0
    while (i < clen) {
        var j = i + alen
        if (document.cookie.substring(i, j) == arg){
            return getCookieVal(j)
        }
        i = document.cookie.indexOf(" ", i) + 1
        if (i == 0) break
    }
    return null
}

function getCookieVal(offset){
    var endstr = document.cookie.indexOf (";", offset)
    if (endstr == -1)
    endstr = document.cookie.length
    return unescape(document.cookie.substring(offset, endstr))
}

function deleteCookie(name,path,domain){
    document.cookie = name + "=" +
    ((path == null) ? "" : "; path=" + path) +
    ((domain == null) ? "" : "; domain=" + domain) +
    "; expires=Thu, 01-Jan-00 00:00:01 GMT"
}

function saveScroll(){ // added function
    var expdate = new Date ()
    expdate.setTime (expdate.getTime() + (expdays*24*60*60*1000)); // expiry date

    var scrOfX = 0, scrOfY = 0;
	  if( typeof( window.pageYOffset ) == 'number' ) {
		//Netscape compliant
		scrOfY = window.pageYOffset;
		scrOfX = window.pageXOffset;
	  } else if( document.body && ( document.body.scrollLeft || document.body.scrollTop ) ) {
		//DOM compliant
		scrOfY = document.body.scrollTop;
		scrOfX = document.body.scrollLeft;
	  } else if( document.documentElement && ( document.documentElement.scrollLeft || document.documentElement.scrollTop ) ) {
		//IE6 standards compliant mode
		scrOfY = document.documentElement.scrollTop;
		scrOfX = document.documentElement.scrollLeft;
	  }
    Data=scrOfX + "_" + scrOfY
    setCookie(cookieName,Data,expdate)
}

function loadScroll(){ // added function


    inf=getCookie(cookieName)
    if(!inf){return}
    var ar = inf.split("_")
    if(ar.length == 2){
        window.scrollTo(parseInt(ar[0]), parseInt(ar[1]))
    }
}

function resetCookie(){
	var expdate = new Date ()
    expdate.setTime (expdate.getTime() + (expdays*24*60*60*1000)); // expiry date
	Data=0 + "_" + 0
    setCookie(cookieName,Data,expdate)

}
