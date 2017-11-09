/**
 * Created by Alex on 09/11/2017.
 */

$('#btnusuarios').click(function () {
    $('#btnusuarios').addClass('active');
    $('#btnempresas').removeClass('active');
    $('#btntickets').removeClass('active');
    $('#btnconsultartickets').removeClass('active');
});

$('#btnempresas').click(function () {
    $('#btnempresas').addClass('active');
    $('#btnusuarios').removeClass('active');
    $('#btntickets').removeClass('active');
    $('#btnconsultartickets').removeClass('active');
});

$('#btntickets').click(function () {
    $('#btntickets').addClass('active');
    $('#btnusuarios').removeClass('active');
    $('#btnempresas').removeClass('active');
    $('#btnconsultartickets').removeClass('active');
});


$('#btnconsultartickets').click(function () {
    $('#btnconsultartickets').addClass('active');
    $('#btnusuarios').removeClass('active');
    $('#btnempresas').removeClass('active');
    $('#btntickets').removeClass('active');
});