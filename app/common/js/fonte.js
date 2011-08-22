function $_freedom_(b)
{
    var i, a,c;
    if(arguments.length > 1){
        c = new Array();
        for(i=0; i<arguments.length; i++) c.push(arguments[i]);
    }
    if(b instanceof Array){
        c = b;
    }
    if(c instanceof Array){
        a = new Array();
        for(i=0; i<c.length; i++) a[i] = document.getElementById(c[i]);
    }
    else a = document.getElementById(b);
    return a;
}
function $_freedom_remove(a) {
    if(a && a.parentNode) a.parentNode.removeChild(a);
}
function _freedom_addEvent(a, b, c, d, e)
{
    if(!a) return false;
    var f;
    if(typeof e != "undefined")
    {	
        if ( typeof(e) != 'string' ){
            var g = [];
            for ( var i = 0; i < e.length; i++ ) g.push(e[i]);
            f = function(e) {
                c.apply(a,[e].concat(g));
            };
        
    }
    else f = function(e) {
        c.apply(a, [e].concat(e));
    };
}
else f = c;
if (a.addEventListener){
    addEventListener(b, f, d);
    return true;
}
else{
    if (a.attachEvent) return a.attachEvent('on' + b, f); else a['on' + b] = f;
}
};
function _freedom_getObjPosition(a)
{
    var b, c;
    a = $_freedom_(a);
    b = a.offsetLeft;
    c = a.offsetTop;
    var body = document.getElementsByTagName('body')[0];
    while (a.offsetParent && a!=body){
        b += a.offsetParent.offsetLeft;
        c += a.offsetParent.offsetTop;
        a = a.offsetParent;
    }
    return {
        x: b, 
        y:c
    };
}


var crossbrowser_BrowserDetect = {
    init: function () {
        this.browser = this.searchString(this.dataBrowser) || "An unknown browser";
        this.version = this.searchVersion(navigator.userAgent) || this.searchVersion(navigator.appVersion) || "an unknown version";
        this.OS = this.searchString(this.dataOS) || "an unknown OS";
    },
    searchString: function (data) {
        for (var i=0;i<data.length;i++)	{
            var dataString = data[i].string;
            var dataProp = data[i].prop;
            this.versionSearchString = data[i].versionSearch || data[i].identity;
            if (dataString) {
                if (dataString.indexOf(data[i].subString) != -1) return data[i].identity;
            }
            else if (dataProp) return data[i].identity;
        }
    },
    searchVersion: function (dataString) {
        var index = dataString.indexOf(this.versionSearchString);
        if (index == -1) return;
        return parseFloat(dataString.substring(index+this.versionSearchString.length+1));
    },
    dataBrowser: [
    {
        string: navigator.userAgent, 
        subString: "Chrome", 
        identity: "Chrome"
    },
{
        string: navigator.userAgent, 
        subString: "OmniWeb", 
        versionSearch: "OmniWeb/", 
        identity: "OmniWeb"
    },
{
        string: navigator.vendor, 
        subString: "Apple", 
        identity: "Safari", 
        versionSearch: "Version"
    },
{
        prop: window.opera, 
        identity: "Opera"
    },
{
        string: navigator.vendor, 
        subString: "iCab", 
        identity: "iCab"
    },
{
        string: navigator.vendor, 
        subString: "KDE", 
        identity: "Konqueror"
    },
{
        string: navigator.userAgent, 
        subString: "Firefox", 
        identity: "Firefox"
    },
{
        string: navigator.vendor, 
        subString: "Camino", 
        identity: "Camino"
    },
{
        string: navigator.userAgent, 
        subString: "Netscape", 
        identity: "Netscape"
    },
{
        string: navigator.userAgent, 
        subString: "MSIE", 
        identity: "Explorer", 
        versionSearch: "MSIE"
                    
    }]
    }