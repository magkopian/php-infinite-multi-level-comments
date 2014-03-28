/**********************************************\
* Copyright (c) 2014 Manolis Agkopian          *
* See the file LICENCE for copying permission. *
\**********************************************/

$(document).ready(function() {

	// Show reply box and hide-button, hide reply-button
	$(document).on('click', '.reply-button', function() {
		$(this).parent().children('.msg-text').show(); // Show textarea
		$(this).parent().children('.hide-reply-box').show(); // Show hide-button
		$(this).hide(); // Hide reply-button
		
		// Clear any previous errors and warnings
		$('.warning').hide();
		$('.error').hide();
		$('.warning p').html('');
		$('.error p').html('');
	});
	
	// Hide reply box and hide-button, show reply-button again
	$(document).on('click', '.hide-reply-box', function() {
		$(this).parent().children('.msg-text').hide();  // Hide textarea
		$(this).parent().children('.reply-button').show(); // Hide hide-button
		$(this).hide(); // Show reply-button
		
		// Clear any previous errors and warnings
		$('.warning').hide();
		$('.error').hide();
		$('.warning p').html('');
		$('.error p').html('');
	});
						
	// On enter insert reply
	$(document).on('keypress', '.msg-text textarea, .msg-text input', function(event) {
		 if (event.keyCode == 13 && event.shiftKey == false) {
			var msg_txt = $(this).parent('.msg-text').children('textarea').val().trim();
			var parent_id = $(this).parent('.msg-text').parent('.message-body').attr('id').slice(8);
			var author_name = $(this).parent('.msg-text').children('[name="author-name"]').val().trim();
			var author_email = $(this).parent('.msg-text').children('[name="author-email"]').val().trim();
			var author_surname = $(this).parent('.msg-text').children('[name="author-surname"]').val().trim(); // Not supposed to be submited, just to block bots
			
			// Send comment and parent id to server via ajax
			$.ajax({
				url: 'ajax/insert_comment.php',
				type: 'post',
				dataType: 'json',
				data: {
					'msg': msg_txt, 
					'parent': parent_id, 
					'author-name': author_name,
					'author-email': author_email,
					'author-surname': author_surname
				},
				success: function (data) {
					if (data.status_code != 0) {
						// Display warning box with message
						if (data.status_code != 1 && data.status_code != 4) {
							$('.error').hide();
							$('.error p').html('');
							$('.warning p').html(data.status_msg.join('<br>'));
							$('.warning').show();
						}
						else {
							$('.warning').hide();
							$('.warning p').html('');
							$('.error p').html(data.status_msg.join('<br>'));
							$('.error').show();
						}
					}
					else {
						if (parent_id != '') {
							// Insert new comment with id="data.message_id"
							$('#message-' + parent_id).after('<ul><li><ul id="message-' + data.message_id + '" class="message-body"><li class="author">' + htmlEncode(data.author) + ':</li><li class="comment-msg">' + htmlEncode(msg_txt) + '</li><li class="reply-button" style="display: list-item;">Click to reply...</li><li class="msg-text" style="display: none;"><input type="text" name="author-name" placeholder="Name" class="txtfield"><input type="text" name="author-surname" placeholder="Surname" class="txtfield"><input type="text" name="author-email" placeholder="Email" class="txtfield"><textarea></textarea></li><li class="hide-reply-box" style="display: none;">Click to hide</li></ul></li></ul>');
						}
						else {
							$('div.comment-section > ul > li:first-child > .message-body:first-child').before('<ul id="message-' + data.message_id + '" class="message-body"><li class="author">' + htmlEncode(data.author) + ':</li><li class="comment-msg">' + htmlEncode(msg_txt) + '</li><li class="reply-button" style="display: list-item;">Click to reply...</li><li class="msg-text" style="display: none;"><input type="text" name="author-name" placeholder="Name" class="txtfield"><input type="text" name="author-surname" placeholder="Surname" class="txtfield"><input type="text" name="author-email" placeholder="Email" class="txtfield"><textarea></textarea></li><li class="hide-reply-box" style="display: none;">Click to hide</li></ul>');
						}
						
						// Hide reply box
						$('.hide-reply-box').click();
						
						// Clear any previous errors and warnings
						$('.warning').hide();
						$('.error').hide();
						$('.warning p').html('');
						$('.error p').html('');
					}
				}
			});
			return false;
		 }
	});
	
});

function htmlEncode(value){
    if (value) {
        return jQuery('<div />').text(value).html();
    } else {
        return '';
    }
}