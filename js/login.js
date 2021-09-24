$(function() {
	$('#login').on(
		'submit',
		function(e) {
			$('.js.error').remove();
			if (!/^([a-z-]+\d?|[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4})$/.test($('#username').val())) {
				$('<li class="js error">Your username has no spaces and is all lowercase, or you may be able to use your email address.</li>').insertBefore($('#username').closest('li'));
				$('#username').val('');
				return false;
			}
		}
	);
});
