$('span.fund-currency').each(function () {
    $(this).html(zhutil.approximate($(this).html(), {base: '萬', extra_decimal: 0}));
});