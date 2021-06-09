var sender_email;
var receiver_email;

$(document).ready(function () {
    var arrow = $('.chat-head img');
    var sendButton = $('.chat-button input');
    var textarea = $('.chat-text textarea');
    var popupWrapper = $('.wrapper');
    var like = $('.like');

    arrow.on('click', function () {
        var src = arrow.attr('src');

        $('.chat-body').slideToggle('fast');
        if (src === 'https://maxcdn.icons8.com/windows10/PNG/16/Arrows/angle_down-16.png') {
            arrow.attr('src', 'https://maxcdn.icons8.com/windows10/PNG/16/Arrows/angle_up-16.png');
        } else {
            arrow.attr('src', 'https://maxcdn.icons8.com/windows10/PNG/16/Arrows/angle_down-16.png');
        }
    });

    sendButton.on('click', function () {
        var msg = textarea.val();
        if(msg !== '') {
            textarea.val('');
            $('.msg-insert').append("<div class='msg-send'>" + msg + "</div>");
            $.ajax({
                url: 'sendMsg.php',
                type: 'post',
                async: false,
                data: {
                    'sender_email': sender_email,
                    'receiver_email': receiver_email,
                    'body': msg
                },
                success: function () {
                }
            });
        }
    });

    textarea.keypress(function (event) {
        var $this = $(this);

        if (event.keyCode === 13) {
            var msg = $this.val();
            if(msg !== '') {
                textarea.val('');
                $('.msg-insert').append("<div class='msg-send'>" + msg + "</div>");
                $.ajax({
                    url: 'sendMsg.php',
                    type: 'post',
                    async: false,
                    data: {
                        'sender_email': sender_email,
                        'receiver_email': receiver_email,
                        'body': msg
                    },
                    success: function () {
                    }
                });
            }
        }
    });

    like.on('click', function (e) {
        popupWrapper.css("visibility", "visible");

        thumb = e.target.closest('.thumbnail');
        if (thumb == null) {
            post = e.target.closest('.post');
            thumb = post.childNodes[1].childNodes[1];
        }
        chatUsername = thumb.childNodes[3].textContent;
        $('#chat-username').text(chatUsername);

        $('.chat-body').slideDown('fast');
        //
        // var parents = e.currentTarget.closest('.panel-body');
        // var btn = parents.childNodes[7];
        // console.log(parents.childNodes[7]);
        // setColor(btn, post);
    });

    // like.addClass('liked');
    $('.comments-section').addClass('hide-comment');
});

function startConv(s_email, r_email) {
    sender_email = s_email;
    receiver_email = r_email;
    $.ajax({
        url: 'getConv.php',
        type: 'post',
        async: false,
        data: {
            'user1': sender_email,
            'user2': receiver_email
        },
        success: function (data) {
            $('.msg-insert').empty();
            var msgs = data['messages'];
            msgs.forEach(function (msg, index) {
                if(msg['user1_email'] === sender_email)
                    $('.msg-insert').append("<div class='msg-send'>" + msg['body'] + "</div>");
                else
                    $('.msg-insert').append("<div class='msg-receive'>" + msg['body'] + "</div>");
            });
        }
    });
}

function setColor(e) {
    var target = e.target,
        status = e.target.classList.contains('liked');

    console.log(status);

    if (status) {
        e.target.classList.remove('liked');
    } else {
        e.target.classList.add('liked');
    }
}

function likeCompany(e, liker_email, company_email) {
    startConv(liker_email, company_email);

    var parents = e.currentTarget.closest('.panel-body');
    var btn = parents.childNodes[1].childNodes[1].childNodes[2];

    console.log(parents.childNodes[1].childNodes[1].childNodes);

    var status = btn.classList.contains('liked');

    if (status) {
        btn.classList.remove('liked');
        $.ajax({
            url: 'like-company.php',
            type: 'post',
            async: false,
            data: {
                'liked': 1,
                'liker_email': liker_email,
                'company_email': company_email
            },
            success: function () {
            }
        });
    } else {
        btn.classList.add('liked');
        $.ajax({
            url: 'like-company.php',
            type: 'post',
            async: false,
            data: {
                'unliked': 1,
                'liker_email': liker_email,
                'company_email': company_email
            },
            success: function () {
            }
        });
    }
    location.reload();
}

function setColor(e, post_id, email, owner_email) {

    startConv(email, owner_email);

    var parents = e.currentTarget.closest('.panel-body');
    var btn = parents.childNodes[7];

    console.log(email);
    var status = btn.classList.contains('liked');

    console.log(status);

    var counter = parents.childNodes[5];
    console.log(counter);
    if (status) {
        btn.classList.remove('liked');
        counter.textContent = parseInt(counter.textContent) + 1;
        $.ajax({
            url: 'like.php',
            type: 'post',
            async: false,
            data: {
                'liked': 1,
                'post_id': post_id,
                'user_email': email
            },
            success: function () {
            }
        });
    } else {
        btn.classList.add('liked');
        counter.textContent = counter.textContent - 1;
        $.ajax({
            url: 'like.php',
            type: 'post',
            async: false,
            data: {
                'unliked': 1,
                'post_id': post_id,
                'user_email': email
            },
            success: function () {
            }
        });
    }
}

function commentBtnClicked(e) {
    var parents = e.target.closest('.panel-body');
    console.log(parents);
    var target = parents.getElementsByClassName('comments-section')[0];
    console.log(target);
    var status = target.classList.contains('hide-comment');

    console.log(status);

    if (status) {
        target.classList.remove('hide-comment');
    } else {
        target.classList.add('hide-comment');
    }
}

function getChatUsername(btn) {
    var thumb = btn.closest('.thumbnail');
    var caption = thumb.getElementsByClassName('text-center')[0];
    return caption.text();
}