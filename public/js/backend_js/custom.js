   /*  --- */    
   $('.price-input').priceFormat({
        prefix: '',
        centsSeparator: '.',
        thousandsSeparator: ',',
        centsLimit: 2
    });
    
    $('.price-input-Rp').priceFormat({
        prefix: 'Rp ',
        centsSeparator: '.',
        thousandsSeparator: ',',
        centsLimit:2
    });
    
    $('.price-input-usd').priceFormat({
        prefix: '$',
        centsSeparator: '.',
        thousandsSeparator: ',',
        centsLimit: 2
    });

    $('.price-input-no-cent').priceFormat({
        prefix: '',
        centsSeparator: '.',
        thousandsSeparator: ',',
        centsLimit: 0
    });

    function numberFormat(number, decPlaces, decSep, thouSep) {
        decPlaces = isNaN(decPlaces = Math.abs(decPlaces)) ? 2 : decPlaces,
        decSep = typeof decSep === "undefined" ? "." : decSep;
        thouSep = typeof thouSep === "undefined" ? "," : thouSep;
        var sign = number < 0 ? "-" : "";
        var i = String(parseInt(number = Math.abs(Number(number) || 0).toFixed(decPlaces)));
        var j = (j = i.length) > 3 ? j % 3 : 0;
    
        return sign +
            (j ? i.substr(0, j) + thouSep : "") +
            i.substr(j).replace(/(\decSep{3})(?=\decSep)/g, "$1" + thouSep) +
            (decPlaces ? decSep + Math.abs(number - i).toFixed(decPlaces).slice(2) : "");
    }
    
    function random_string(length=7){
        let randomStr = Math.random().toString(36).substring(7);
        return randomStr;
    }