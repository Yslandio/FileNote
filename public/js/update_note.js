document.getElementById('updateNote').addEventListener('show.bs.modal', function (event) {
    var button = event.relatedTarget;

    var note = button.getAttribute('data-bs-note');

    note = JSON.parse(note);

    ['header', 'body', 'footer'].forEach(element => {
        document.querySelector('#modal-'+element+'-update').style.backgroundColor = element == 'body' ? note.color+'50' : note.color+'80';
    });

    document.querySelector('#modal-id-update').value = note.id;
    document.querySelector('#modal-title-update').value = note.title;
    document.querySelector('#modal-content-update').value = note.content;
    document.querySelector('#modal-color-update').value = note.color;
});
