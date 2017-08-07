$("#order-form").trigger('reset');//очистка формы при обновлении

$('.order__form-button').on('click', function (e) {

    var email = $('input[name=email]').val();
    var name = $('input[name=name]').val();
    var phone = $('input[name=phone]').val();
    var street = $('input[name=street]').val();
    var home = $('input[name=home]').val();
    var part = $('input[name=part]').val();
    var appt = $('input[name=appt]').val();
    var floor = $('input[name=floor]').val();
    var comments = $('textarea[name=comments]').val();

    var card = $("#card").prop("checked");
    var change = $("#change").prop("checked");
    var callback = $("#callback").prop("checked");
   var int_card = Number(card);
   var int_change = Number(change);
   var int_callback = Number (callback);
//проверка - число инт
    function isInt(value) {
        return !isNaN(value) && (function(x) { return (x | 0) === x; })(parseFloat(value))
    }
   //проверка email
    function isValidEmailAddress(emailAddress) {
        var pattern = new RegExp(/^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/i);
        return pattern.test(emailAddress);
    }
    //+7 (564) 565 46 56

    //проверка телефона
    function isValidPhone(phone) {
        var pattern = new RegExp(/^(\s*)?(\+)?([- _():=+]?\d[- _():=+]?){10,14}(\s*)?$/);
        return pattern.test(phone);
    }

    if (street==0 || phone==0 || name ==0 || email==0 || home==0 || part == 0 || appt == 0 || floor == 0){
        alert("Заполните все поля!");
    }

    else if((!isValidEmailAddress(email)))
    {
        alert("Неверный email адрес!");

    }
    else if (!isInt(home)){
        alert("Неверный номер дома!");
    }
    else if (!isInt(part)){
        alert("Неверный номер корпуса!");
    }
    else if (!isInt(floor)){
        alert("Неверный этаж!");
    }
    else if (!isInt(appt)){
        alert("Неверный ввод номера квартиры!");
    }
    else if ( !isValidPhone(phone)){
       alert("Неверный номер телефона!");
    }


else {
        $.ajax({
            url: '/burgers/form-handler.php',
            method: 'POST', //отправляем данные методом пост
            data: {
                email: email,
                name: name,
                phone: phone,
                street: street,
                home: home,
                part: part,
                appt: appt,
                floor: floor,
                change: int_change,
                card: int_card,
                comments: comments,
                callback: int_callback
            }
        }).done(function (data) {
            $("#order-form").trigger('reset');
            alert("Ваш заказ принят! Мы отправили Вам письмо с деталями заказа. ");
        });

        //очистили форму

    }
});

