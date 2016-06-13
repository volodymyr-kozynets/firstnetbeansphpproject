function confirmDelete(){
    if(confirm("Удалить продукцию из бланка заказа?")){
        return true;
    }else{
        return false;
    }
}

function confirmPageDelete(){
    if(confirm("Удалить страницу?")){
        return true;
    }else{
        return false;
    }
}

function confirmInvoiceDelete(){
    if(confirm("Подумайте хорошо... Удалить Накладную!?")){
        return true;
    }else{
        return false;
    }
}

function confirmUserDelete(){
    if(confirm("Подумайте хорошо... Удалить Пользователя!?")){
        return true;
    }else{
        return false;
    }
}
