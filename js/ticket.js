$("#add_comment").on('click', function(){
    let ticketId = $(this).data("ticketid");
    let text = $("#comment").val();

    $.ajax({
        method: "POST",
        url: "http://localhost:8888/ajax",
        data: { 
            "method": "addCommentToTicket", 
            'ticketId': ticketId,
            "commentText": text
        },
        dataType: "json",
    })
    .done(function( data ) {
        if (data.success){
            $("#comment").val('');
            let newCommentBlock = `
                    <div class="bordered" style="margin-bottom:10px;">
                        <b>`+data.comment.creatorRow+`</b><br>
                        `+data.comment.text+`<br>
                    </div>`;
            $("#commentsBlock").prepend(newCommentBlock);
        } else {
            alert('Не записалось в БД');
        }
    });
});

$("#add_offer").on('click', function(){
    let ticketId = $(this).data("ticketid");
    let userId = $("#offer_staff_id").val();

    $.ajax({
        method: "POST",
        url: "http://localhost:8888/ajax",
        data: {
            "method": "addTicketOffer", 
            'ticketId': ticketId,
            "userId": userId
        },
        dataType: "json",
    })
    .done(function( data ) {
        if (data.success){
            alert('Репетитору отправлено уведомление о предложении');
        } else {
            alert('Не записалось в БД');
        }
    });
});

$("#reject_offer").on('click', function(){
    let ticketId = $(this).data("ticketid");

    $.ajax({
        method: "POST",
        url: "http://localhost:8888/ajax",
        data: {
            "method": "rejectTicketOffer", 
            'ticketId': ticketId
        },
        dataType: "json",
    })
    .done(function( data ) {
        if (data.success){
            alert('Администратору отправлено уведомление об отказе');
            $("#offer_accept_block").remove();
        } else {
            alert('Не записалось в БД');
        }
    });
});

$("#accept_offer").on('click', function(){
    let ticketId = $(this).data("ticketid");

    $.ajax({
        method: "POST",
        url: "http://localhost:8888/ajax",
        data: {
            "method": "acceptTicketOffer", 
            'ticketId': ticketId
        },
        dataType: "json",
    })
    .done(function( data ) {
        if (data.success){
            alert('Администратору отправлено уведомление о назначении');
            window.location.reload();
        } else {
            alert('Не записалось в БД');
        }
    });
});

$("#close_ticket").on('click', function(){
    let ticketId = $(this).data("ticketid");

    $.ajax({
        method: "POST",
        url: "http://localhost:8888/ajax",
        data: {
            "method": "closeTicket", 
            'ticketId': ticketId
        },
        dataType: "json",
    })
    .done(function( data ) {
        if (data.success){
            alert('Заявка закрыта с успехом!');
            window.location.reload();
        } else {
            alert('Не записалось в БД');
        }
    });
});

$("#reopen_ticket").on('click', function(){
    let ticketId = $(this).data("ticketid");

    $.ajax({
        method: "POST",
        url: "http://localhost:8888/ajax",
        data: {
            "method": "reopenTicket", 
            'ticketId': ticketId
        },
        dataType: "json",
    })
    .done(function( data ) {
        if (data.success){
            alert('Заявка сброшена!');
            window.location.reload();
        } else {
            alert('Не записалось в БД');
        }
    });
});