function exp(id) {
    'use strict'
    if (confirm('期限切れにしますか？')) {
        document.getElementById(`form_${id}_exp`).submit();
    }

}

function no_exp(id) {
    'use strict'
    if (confirm('持ち越しますか？')) {
        document.getElementById(`form_${id}_no_exp`).submit();
    }

}

function pass_exp(id) {
    'use strict'

    if (confirm('本当にパスしますか？')) {
        document.getElementById(`form_${id}_pass_exp`).submit();
    }
}

function pass(id) {
    'use strict'

    if (confirm('本当にパスしますか？')) {
        document.getElementById(`form_${id}_pass`).submit();
    }
}

function comp_exp(id) {
    document.getElementById(`modal-comp-exp_${id}`).style.display = 'flex';

}

function complete(id) {

    document.getElementById(`modal-comp_${id}`).style.display = 'flex';

}



window.closeCompModal = function(id) {
    document.getElementById(`modal-comp_${id}`).style.display = 'none';
}

window.closeCompExpModal = function(id) {
    document.getElementById(`modal-comp-exp_${id}`).style.display = 'none';
}

window.closeExpBooksModal = function() {
    document.getElementById('modal-exp-books').style.display = 'none';
}
