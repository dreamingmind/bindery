$(document).ready(function(){
	session.init();
});

var session = {
	//year, month, day, hours, minutes, seconds, milliseconds
	time_min: new Date('2015','2','25','7','00','0'),
	time_max: new Date('2015','2','25','23','00','0'),
	time_increment: 30*60*1000, // 60*1000 = 1 minute
	time: [],
	
	init: function(){
		session.fill_time();
		$('.end_slide')
			.attr('max', session.time.length-1);

		$('.start_slide')
			.attr('max', session.time.length - 5)
			.mousemove(function(e){
				var start = $(e.currentTarget).val();
				
				$('#DateStartTime').val(session.time[start]);
				$('.end_slide')
					.attr('min', parseInt(start) + 3)
					.trigger('mousemove');
			
				session.duration();

			});
		$('.end_slide').mousemove(function(e){
			var end = $(e.currentTarget).val();
			$('#DateEndTime').val(session.time[end]);
			
			session.duration();
		});
	},
	
	duration: function(){
		var duration = (parseInt($('.end_slide').val()) - parseInt($('.start_slide').val()))/2;
		$('.duration').html(duration.toString() + ' hour session');		
	},
	
	fill_time: function (){
		var start = session.time_min.getTime();
		var end = session.time_max.getTime();
		for (var i = start; i <= end; i+=session.time_increment) {
			session.time.push(session.hm(new Date(i)));
		}

	},
	
	hm: function(time){
		var min = time.getMinutes().toString().length == 1 ? ':0' : ':';
		var meridian = time.getHours() > 11 ? 1 : 0;
		var noon = time.getHours() > 12 ? 1 : 0;
		return (time.getHours() - (noon * 12)) + min + time.getMinutes() + (meridian ? ' PM' : ' AM');
	}
	
}