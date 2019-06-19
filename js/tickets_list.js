$(document).ready(function() {
    // Добавляем поиск по колонкам
    $('#tickets_list_table thead tr').clone(true).appendTo( '#tickets_list_table thead' );
    $('#tickets_list_table thead tr:eq(1) th').each( function (i) {
        // var title = $(this).text();
        $(this).html( '<input type="text" placeholder="Поиск" />' );
 
        $( 'input', this ).on( 'keyup change', function () {
            if ( table.column(i).search() !== this.value ) {
                table
                    .column(i)
                    .search( this.value )
                    .draw();
            }
        } );
    } );
 
    //делаем таблицу ДатаТэйблом
    var table = $('#tickets_list_table').DataTable( {
        orderCellsTop: true,
        fixedHeader: true,
        language: {
            "lengthMenu": "Показать _MENU_ результатов на странице",
            "zeroRecords": "Ничего не найдено",
            "info": "Показывать с _PAGE_ по _PAGES_",
            "infoEmpty": "Нет доступных данных",
            "infoFiltered": "(отфильтровано из _MAX_ записей)",
            "decimal":        "",
            "emptyTable":     "Нет данных в таблице",
            "infoPostFix":    "",
            "thousands":      ",",
            "loadingRecords": "Загрузка...",
            "processing":     "Процесс...",
            "search":         "Поиск:",
            "paginate": {
                "first":      "Первый",
                "last":       "Последний",
                "next":       "Следующая",
                "previous":   "Предыдущая"
            },
            "aria": {
                "sortAscending":  ": фильтровать по возрастанию",
                "sortDescending": ": фильтровать по убыванию"
            }
        },
        order: []
    });

    $('#tickets_list_table').css( "width", "100%!important" );
} );