$(".phone").mask("8(999) 999-9999");
function validateCreateTicketFields(){
    const elemsToCheck = {
        'subject': 'Предмет',
        'student_last_name': 'Студент: фамилия',
        'student_name': 'Студент: имя',
        'student_middle_name': 'Студент: отчество',
        'student_gender': 'Студент: пол',
        'client_last_name': 'Клиент: фамилия',
        'client_name': 'Клиент: имя',
        'client_middle_name': 'Клиент: отчество',
        'client_phone': 'Клиент: телефон'};
    let allRight = true;
    let badElems = [];
     $.each(elemsToCheck, function(id, desc) {
        if (!$("#"+id).val()){
            allRight = false;
            badElems.push(desc);
        }
    }); 
    return {"success": allRight, "badElems": badElems};
}
$("#create_ticket_btn").on("click", function(){
    let check = validateCreateTicketFields();
    if (!check["success"]){
        alert("Заполните следющие поля: " + check["badElems"].join(', ') + '.');
        return;
    }

    $.ajax({
        method: "POST",
        url: "http://localhost:8888/ajax",
        data: { 
            "method": "createTicket", 
            'subject': $("#subject").val(),
            'student_last_name': $("#student_last_name").val(),
            'student_name': $("#student_name").val(),
            'student_middle_name': $("#student_middle_name").val(),
            'student_gender': $("#student_gender").val(),
            'student_age': $("#student_age").val(),
            'client_last_name': $("#client_last_name").val(),
            'client_name': $("#client_name").val(),
            'client_middle_name': $("#client_middle_name").val(),
            'client_phone': $("#client_phone").val(),
            'comment': $("#comment").val()},
        dataType: "json",
    })
    .done(function( data ) {
        if (data.success){
            $("#create_ticket_block").html(
                `<a target="_blank" href="/ticket/?ticket_id=`+data.ticketId+`">Заявка</a><br>
                <a href="/create_ticket/">Создать новую</a>`
            );
            
        } else {
            alert('Неправильная комбинация логина и пароля');
        }
    });
});
