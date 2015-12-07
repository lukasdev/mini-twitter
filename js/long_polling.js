$(function(){
	var base = $('.base').attr('id');

	function longPolling(timestamp){
		var user_id = localStorage.user_id;
		$.ajax({
			method: 'GET',
			url: base+'/sys/longPolling.php',
			data: {user_id: user_id, timestamp: timestamp},
			dataType: 'json',
			success: function(retorno){
				if(retorno.results != ''){
					$.each(retorno.results, function(i, val){
						var tweet = '<article class="tweet">';
					 		tweet += '<span class="nome"><a href="'+base+'/'+retorno.results[i].nickname+'">'+retorno.results[i].nome+'</a> disse:</span>';
							tweet += '<p>'+retorno.results[i].tweet+'</p>';
							tweet += '<span class="date">'+retorno.results[i].date+'</span></article>';
						$('#content').prepend(tweet);
					});
				}

				longPolling(retorno.timestamp);
			}
		});
	}

	longPolling();
});