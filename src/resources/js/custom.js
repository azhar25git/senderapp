$('#filter-btn').on('click', function(e) {
    e.preventDefault();
    var year = $('input[name=year]').val() ? parseInt($('input[name=year]').val()): 0;
    var month = $('input[name=month]').val() ? parseInt($('input[name=month]').val()): 0;
    console.log(year, month);
    window.location = "/people?year="+year+"&month="+month;
});

$(".checkbox").on("click", function(e) {
    $(this).parent().parent().toggleClass('checked-row');
});