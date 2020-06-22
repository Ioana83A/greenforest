// Copyright (c) 2010 Cristian Adam <cristian.adam@gmail.com>
// License: MIT
//
// This script replaces s comma bellow and t comma bellow
// on operating systems which do not support them with
// s cedilla and t cedilla, which are more widespread but
// incorrect in Romanian language.
//
// Partial substitution mode is used for Android where the
// s comma bellow character is present and t comma bellow
// is missing, but t cedilla is implemented as t comma bellow
// so we're replacing only t comma bellow

function DiacriticsCommaToCedilla(node, partialSubstitution) {
    if (node.nodeName == "#text") {
        if (!partialSubstitution) {
            node.nodeValue = node.nodeValue.replace(/ș/g, "ş");
            node.nodeValue = node.nodeValue.replace(/Ș/g, "Ş");
        }
        node.nodeValue = node.nodeValue.replace(/ț/g, "ţ");
        node.nodeValue = node.nodeValue.replace(/Ț/g, "Ţ");
        return;
    }

    var i;
    for (i = 0; i < node.childNodes.length; ++i) {
        DiacriticsCommaToCedilla(node.childNodes[i], partialSubstitution);
    }
}

function DiacriticsCommaToCedillaInTitle(partialSubstitution) {
    if (!partialSubstitution) {
        document.title = document.title.replace(/ș/g, "ş");
        document.title = document.title.replace(/Ș/g, "Ş");
    }
    document.title = document.title.replace(/ț/g, "ţ");
    document.title = document.title.replace(/Ț/g, "Ţ");
}

function DiacriticsConfigureTextElement(element, text) {
    element.innerHTML = text;
    element.style.width = "auto";
    element.style.visibility = "hidden";
    element.style.position = "absolute";
    element.style.fontSize = "96px";
}

// http://stackoverflow.com/questions/1955048
function DiacriticsGetStyle(element, property) {
    var camelize = function (str) {
        return str.replace(/\-(\w)/g, function(str, letter){
            return letter.toUpperCase();
        });
    };

    if (element.currentStyle) {
        return element.currentStyle[camelize(property)];
    } else if (document.defaultView && document.defaultView.getComputedStyle) {
        return document.defaultView.getComputedStyle(element,null)
                                   .getPropertyValue(property);
    } else {
        return element.style[camelize(property)];
    }
}

function DiacriticsOnOlderOperatingSystems() {
    var userAgent = navigator.userAgent.toLowerCase();

    if (userAgent.indexOf("bot") != -1 ||
        userAgent.indexOf("crawl") != -1 ||
        userAgent.indexOf("slurp") != -1 ||
        userAgent.indexOf("archive") != -1)
    {
        return;
    }

    var normalText = document.createElement("div");
    DiacriticsConfigureTextElement(normalText, "sStT");

    var diacriticsText = document.createElement("div");
    DiacriticsConfigureTextElement(diacriticsText, "șȘțȚ");

    var partialDiacriticsText = document.createElement("div");
    DiacriticsConfigureTextElement(partialDiacriticsText, "șȘţŢ");

    document.body.insertBefore(normalText, document.body.firstChild);
    document.body.insertBefore(diacriticsText, document.body.firstChild);
    document.body.insertBefore(partialDiacriticsText, document.body.firstChild);

    // Sometimes at various zoom settings there is a +1 difference
    var doChange = Math.abs(normalText.offsetWidth - diacriticsText.offsetWidth) > 1;
    var havePartialDiacritics = Math.abs(normalText.offsetWidth - partialDiacriticsText.offsetWidth) <= 1;

    // Pocket Internet Explorer on Windows Mobile 6.5 returns 0
    if (normalText.offsetWidth == 0 &&
        diacriticsText.offsetWidth == 0)
    {
        doChange = true;
        havePartialDiacritics = false;
    }

/*
    alert("doChange: " + doChange + ", havePartialDiacritics: " + havePartialDiacritics + "\n" +
          normalText.offsetWidth + " vs " + diacriticsText.offsetWidth + "\n" +
          normalText.offsetWidth + " vs " + partialDiacriticsText.offsetWidth + "\n" +
          "fontFamily: " + DiacriticsGetStyle(diacriticsText, "font-family"));
*/

    document.body.removeChild(normalText);
    document.body.removeChild(diacriticsText);
    document.body.removeChild(partialDiacriticsText);

    if (doChange)  {
        DiacriticsCommaToCedilla(document.body, havePartialDiacritics);
        DiacriticsCommaToCedillaInTitle(havePartialDiacritics);
    }
}

if (window.attachEvent) {
    window.attachEvent("onload", DiacriticsOnOlderOperatingSystems);
}
else if (window.addEventListener) {
    window.addEventListener("load", DiacriticsOnOlderOperatingSystems, false);
}