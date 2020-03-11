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

