function saveWord(word_id, algorithm_id, hash) {
    $.ajax({
        url: '/hash/save',
        cache: false,
        data: {
            '_token': $('meta[name=csrf-token]').attr('content'),
            'word_id': word_id,
            'algorithm_id': algorithm_id,
            'hash': hash
        },
        type: "POST",
        success: function (data) {
            $('#answer' + data['word_id']).html('Ok');
        }
    });
}