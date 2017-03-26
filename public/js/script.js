$('.results__block').on('click', '.table__tr', function () {
    $.ajax({
        url: '/hash/save',
        data: {'_token':$('meta[name=csrf-token]').attr('content'),
            'word_id':$(this).data('word_id')},
        type: "POST",
        success: function (data) {
            alert(data['word_id']);
            $('#answer'+data['word_id']).html('Ok');
        }
    });
});