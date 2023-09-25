<style type="text/css">
	#calendar .fc-toolbar {
		border: 1px solid #dddddd;
		padding: 14px 10px;
		margin-bottom: 0px;
	}
	#calendar .fc-toolbar h2 {
		font-size: 16px !important;
		text-transform: uppercase !important;
		text-align: center;
		margin: 0px !important;
	}
	#calendar .fc-toolbar h2::before {
		content: none;
	}
	#calendar .fc-toolbar button {
	    font-weight: 600;
	    font-size: 14px;
	    color: #000000;
	    letter-spacing: 0px;
	    line-height: 24px;
	    background-color: transparent;
	    border-color: transparent;
	}

	#calendar .fc-view-container table th {
		font-weight: 500;
		font-size: 11px;
		color: #000000;
		text-transform: none;
		letter-spacing: 0px;
		line-height: 22px;
		text-align: left;
		padding-left: 9px;
		background: white;
	}
	#calendar .fc-view-container table td {
	    font-weight: 500;
	    font-size: 14px;
	    color: #000000;
	    letter-spacing: 0px;
	    line-height: 24px;
	}

	@media (max-width: 767px) {
		#calendar .fc-toolbar h2 {
		    font-size: 16px;
		    letter-spacing: 0px;
		    line-height: 26px;
		}
		#calendar .fc-toolbar button {
		    font-size: 12px;
		    letter-spacing: 0px;
		    line-height: 22px;
		}
		#calendar .fc-view-container table th {
		    font-size: 12px;
		    letter-spacing: 0px;
		    line-height: 22px;
		}
		#calendar .fc-view-container table td {;
		    font-size: 12px;
		    letter-spacing: 0px;
		    line-height: 22px;
		}
	}

	@media (max-width: 575px) {
		#calendar .fc-toolbar h2 {
		    font-size: 14px;
		    letter-spacing: 0px;
		    line-height: 24px;
		}
		#calendar .fc-toolbar button {
		    font-size: 10px;
		    letter-spacing: 0px;
		    line-height: 20px;
		}
		#calendar .fc-view-container table th {
		    font-size: 10px;
		    letter-spacing: 0px;
		    line-height: 20px;
		}
		#calendar .fc-view-container table td {;
		    /* font-size: 10px;
		    letter-spacing: 0px;
		    line-height: 20px; */
		}
	}
</style>

<h2>Bookings</h2>

<div class="calendar-outer">
	<div class="calendar-container">
		<div id="calendar"></div>
		<div class="calendar-content"></div>
		<!--<div class="calendar-timeslot-info"><?= $text_not_available; ?></div> -->
	</div>
</div>

<div id="book-appointment" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h2><?= $booking_title; ?></h2>
            </div>
            <form method="post" enctype="multipart/form-data" class="form-horizontal">
                <div class="modal-body">
                    <div class="form-group required">
                        <input type="text" name="name" value="<?= $name; ?>" id="input-name" class="form-control" placeholder="<?= $entry_name; ?>" />
                        <?php if ($error_name) { ?>
                            <div class="text-danger"><?= $error_name; ?></div>
                        <?php } ?>                              
                    </div>

                    <div class="form-group required">
                        <input type="tel" name="contact" value="<?= $contact; ?>" id="input-contact" class="form-control input-number" placeholder="<?= $entry_contact; ?>" />
                        <?php if ($error_contact) { ?>
                            <div class="text-danger"><?= $error_contact; ?></div>
                        <?php } ?>
                    </div>

                    <div class="form-group required">
                        <input type="text" name="email" value="<?= $email; ?>" id="input-email" class="form-control" placeholder="<?= $entry_email; ?>" />
                        <?php if ($error_email) { ?>
                            <div class="text-danger"><?= $error_email; ?></div>
                        <?php } ?>
                    </div>

                     <div class="form-group required">
						 <input type="text" readonly name="outlet" class="form-control" placeholder="Event Name"/>
                    </div>

                    <div class="form-group required">
                        <textarea name="message" rows="10" id="input-message" class="form-control" placeholder="<?= $entry_message; ?>"><?= $message; ?></textarea>
                        <?php if ($error_message) { ?>
                            <div class="text-danger"><?= $error_message; ?></div>
                        <?php } ?>
                    </div>
                    <input type="hidden" name="event_id" value="" class="input-event" class="form-control" placeholder="<?= $entry_event; ?>" />
					<input type="hidden" name="date" value="" class="input-date" class="form-control" placeholder="<?= $entry_date; ?>" />
					<input type="hidden" name="time" value="" class="input-time" class="form-control" placeholder="<?= $entry_time; ?>" />
                    <div class="modal-footer">
                        <div id="input-captcha">
                            <?= $captcha; ?>
                            <?php if ($error_message) { ?>
                                <div class="text-danger"><?= $error_message; ?></div>
                            <?php } ?>
                        </div>
                        <button type="button" id="booking-submit" class="btn btn-primary pull-sm-right"><?= $button_submit; ?></button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript">
    $("#booking-submit").click(function(){
         $.ajax({
            url: 'index.php?route=extension/module/calendar/validate',
            data: $('form').serialize(),
            dataType: 'json',
            type: 'post',
            success: function(json){
                $('.alert, .text-danger').remove();
                $('.form-group').removeClass('has-error');

                if(json['error']){
                    for(i in json['error']) {
                        var element = $('#input-' + i);
                        $(element).after('<div class="text-danger">' + json['error'][i] + '</div>');
                    }

                    $('.text-danger').parent().addClass('has-error');
                }

                if(json['success']){
                    swal({
                        type: "success",
                        title: "Book Appointment", 
                        html: json['success'],
                        showConfirmButton: true,
                    }).then(function() {
                        location.reload();
                    });
                }
            }
         });
    });
</script>

<script type="text/javascript">
	$(document).ready(function() {
		$.ajax({
			url: 'index.php?route=extension/module/calendar/getCalendar',
			type: 'post',
			data: {module_id: '<?php echo $module_id; ?>'},
			dataType: 'json',
			beforeSend: function() {
			},
			success: function(json) {
				var calendarEl = document.getElementById('calendar');

	    		var calendar = new FullCalendar.Calendar(calendarEl, {
				  plugins: ['dayGrid' ],
				  defaultView: 'dayGridMonth',
			      editable: false,
			      eventLimit: true,
			      eventBackgroundColor: 'transparent',
			      eventTextColor: '#000',
			      eventBorderColor: 'transparent',
				  events: json.events,
				  eventClick:  function(info, view) {
			            // $('#modalTitle').html(event.title);
			            // $('#modalBody').html(event.description);
			            // $('#eventUrl').attr('href',event.url);
			            // $('#calendarModal').modal();

			         console.log(info.el);
			            if (moment(info.event.start).format('YYYY-MM-DD') >= moment().format('YYYY-MM-DD')) {
			            $.ajax({
			            	url: 'index.php?route=extension/module/calendar/getCalendarDetail',
			            	type: 'post',
							data: {cevent_id: info.event.id, selected_date:  moment(info.event.start).format('YYYY-MM-DD')},
							dataType: 'json',
							beforeSend: function() {
								$('.calendar-info').remove();
								$('.calendar-timeslot').remove();
								$('.calendar-timeslot-info').empty();
							},
							success: function(json) {
								// $('#calendarModal').modal();
								let timeslotHTML = '';
								for(let i = 0; i < json.info['timeslots'].length; i++) {
								// 	$('.calendar-timeslot-info').append('<div class="calendar-timeslot"><a data-date="' + moment(info.event.start).format('YYYY-MM-DD') + '" data-time="' + json.info['timeslots'][i]['time'] + '" class="btn-timeslot">' + json.info['timeslots'][i]['time'] + '</a></div>');
								console.log(json.info['timeslots']);
									timeslotHTML += '<div class="calendar-timeslot"><a data-date="' + moment(info.event.start).format('YYYY-MM-DD') + '" data-time="' + json.info['timeslots'][i]['time'] + '" class="btn-timeslot">' + json.info['timeslots'][i]['time'] + '</a></div>';
								}
								
                                //pammed
                        
						        document.querySelectorAll('.le-cusoim').forEach(function(item) {
                                    item.remove();
                                });
                                let amy = info.el
                                
                                if(timeslotHTML === '') {
                                    timeslotHTML = 'No timeslot available';
                                }
                                var myhtml = `<div class='le-cusoim' style='background: #F3F3F3; min-height: 100px; display: block; z-index: 9; position: static;'><div class="calendar-info2" style="padding-top: 15px; text-align: center"><div class="inner2"><div class="calendar-title2">` + json.info['name'] + '&nbsp;-&nbsp;' + `</div><div class="calendar-datetime2"><span class="calendar-date2">`+ moment(info.event.start).format('MMMM DD, YYYY') + `</span><span class="calendar-time2"></span></div></div><div class="calendar-button2"></div></div><div class="calendar-timeslot-info">` + timeslotHTML +`</div></div>`

						        $(amy).parent().parent().parent().parent().parent().append(myhtml);
								
								$('.btn-timeslot').each(function(){
						    		$(this).on('click', function() {
						    			var time = $(this).data('time');
						    			$('.calendar-button').empty();
						    			$('.btn-timeslot').removeClass('active');

						    			$('.le-cusoim .calendar-info2 .calendar-datetime2 .calendar-time2').html('&nbsp;-&nbsp;' + time);
						    			$('.le-cusoim .calendar-info2 .calendar-button2 a').remove();
										$('.le-cusoim .calendar-info2 .calendar-button2').append('<a id="submit-booking" data-date="'+ moment(info.event.start).format('YYYY-MM-DD') +'" data-time="' + time + '" class="btn btn-primary" data-toggle="modal" data-target="#book-appointment">Book Now</a>');

										$('.input-event').val(json.info['cevent_id']);
										$('.input-date').val($('#submit-booking').data('date'));
										$('.input-time').val($('#submit-booking').data('time'));

							    		$(this).addClass('active');

								    	//pammed
										let title23 = $(this).parent().parent().parent().parent().find(".le-cusoim .calendar-title2").text();
										let date23 = $(this).parent().parent().parent().parent().find(".le-cusoim .calendar-date2").text();
										let time23 = $(this).parent().parent().parent().parent().find(".le-cusoim .calendar-time2").text();
										$("input[name=outlet]").val(title23 + date23 + time23);
						    		});
						    	});
							}
			            });
			        }
			        },
				});

				calendar.render();
			}
		});
	});
</script>


<script type="text/javascript">
	function isEmpty(obj) {
		for(var key in obj) {
			if(obj.hasOwnProperty(key))
				return false;
			}
		return true;
	}

	function destroySlick() {
		$('.calendar-image-main').on('destroy', function(event, slick){
			$('.calendar-image-main').html('');
		});

		$('.calendar-image-main').slick('unslick');

		$('.calendar-image-additional').on('destroy', function(event, slick){
			$('.calendar-image-additional').html('');
		});

		$('.calendar-image-additional').slick('unslick');
	}

	function initSlick() {
		$('.calendar-image-main').on('init', function(event, slick){
	});

	$('.calendar-image-main').on('afterChange', function(event, slick, currentSlide){

	});

	$('.calendar-image-main').slick({
		slidesToShow: 1,
		slidesToScroll: 1,
		arrows: false,
		fade: true,
		infinite: false,
		asNavFor: '.calendar-image-additional',
		prevArrow: "<div class='pointer slick-nav left prev'><div class='absolute position-center-center'><i class='fa fa-chevron-left fa-2em'></i></div></div>",
		nextArrow: "<div class='pointer slick-nav right next'><div class='absolute position-center-center'><i class='fa fa-chevron-right fa-2em'></i></div></div>",
	});

	$('.calendar-image-additional').slick({
		slidesToShow: 4,
		slidesToScroll: 1,
		arrows: true,
		asNavFor: '.calendar-image-main',
		dots: false,
		centerMode: false,
		focusOnSelect: true,
		infinite: false,
		prevArrow: "<div class='pointer slick-nav left prev'><div class='absolute position-center-center'><i class='fa fa-chevron-left'></i></div></div>",
		nextArrow: "<div class='pointer slick-nav right next'><div class='absolute position-center-center'><i class='fa fa-chevron-right'></i></div></div>",
		responsive: [
			{
				breakpoint: 767,
				settings: {
					slidesToShow: 3,
					slidesToScroll: 1,
				}
			},
		],
	});

	$('.calendar-image-additional').slick('setPosition');
	}

	$(window).load(function () {
		initSlick();
	});

	$(document).ready(function () {
		$('.main_images').magnificPopup({
			type: 'image',
			gallery: {
			enabled: true
		}
	});

	$('#calendarModal').on('shown.bs.modal', function (e) {
	    $('.calendar-image-main').resize();
	  })

	});
</script>

<script>
	$(".fc-row").click(function(){
		alert('test');
	})
</script>

<style>
    .fc-event-container a {
        cursor: pointer;
    }
    .fc-event {
        font-size: 0.75em !important;
    }

    .fc-event:hover {
        color: #fff !important;
		background: #000 !important;
    }
    .calendar-container #calendar {
        width: 100%;
    }
    .calendar-container .calendar-content {
        width: 100%;
		background: #F3F3F3;
    }
    .calendar-container .calendar-content .calendar-info {
        padding: 30px 30px 0;
    }
    .calendar-container .calendar-content .calendar-info * {
		font-size: 16px !important;
		font-weight: 500 !important;
	}
    .calendar-container .calendar-timeslot-info {
        display: flex;
        justify-content: flex-start;
        align-items: center;
        flex-wrap: wrap;
        background-color: #F3F3F3;

        font-weight: 600;
        font-size: 12px;
        color: #473c38;
        letter-spacing: 1px;
        line-height: 22px;
        padding: 30px;
    }
    .calendar-container .calendar-timeslot-info > * {
        display: inline-flex;
        justify-content: center;
        align-items: center;
        width: calc(33.333% - 10px);
        margin-bottom: 5px;
    }
    .calendar-container .calendar-timeslot-info > *:not(:nth-child(3n+1)):not(:first-child) {
        margin-left: 15px;
    }
	.calendar-container .calendar-timeslot-info .btn-timeslot:hover {
		color: #fff !important;
		cursor: pointer;
	}
    .calendar-container .calendar-timeslot-info .btn-timeslot {
        background-color: #ffffff;
        font-weight: 500;
        font-size: 12px;
        color: #000000;
        letter-spacing: 1px;
        line-height: 22px;
        text-align: center;
        text-transform: uppercase;
        border: 1px solid #000000;
        min-width: 138px;
        height: auto;
        padding: 7px 14px;
    }
    .calendar-container .calendar-timeslot-info .btn-timeslot:hover,
    .calendar-container .calendar-timeslot-info .btn-timeslot:focus {
        background-color: #000000;
        color: #ffffff;
        border: 1px solid #000000;
        transition: all 0.6s ease-in;
    }
    .calendar-container .calendar-timeslot-info .btn-timeslot.active {
        background-color: #000000;
        color: #ffffff !important;
        border: 1px solid #000000;
    }

    @media (max-width: 1280px) {
        .calendar-container {
            display: block;
        }
        .calendar-container #calendar {
            width: 100%;
        }
        .calendar-container .calendar-content {
            width: 100%;
            margin-left: 0px;
        }
    }
    @media (max-width: 575px) {
        .calendar-container .calendar-timeslot-info {
            font-size: 10px;
            line-height: 20px;
        }
        .calendar-container .calendar-timeslot-info > * {
            width: calc(50% - 10px);
        }
        .calendar-container .calendar-timeslot-info > *:not(:nth-child(3n+1)):not(:first-child) {
            margin-left: 0px;
        }
        .calendar-container .calendar-timeslot-info > *:not(:nth-child(2n+1)):not(:first-child) {
            margin-left: 15px;
        }
        .calendar-container .calendar-timeslot-info .btn-timeslot {
            font-size: 10px;
            min-width: 100px;
            min-height: 32px;
            height: 32px;
            padding: 6px 12px;
        }
    }

    #book-appointment .modal-dialog {
        width: calc(100vw - 20px);
        max-width: 900px;
    }
    #book-appointment .modal-dialog .modal-content {
        box-shadow: none;
    }
    #book-appointment .modal-dialog .modal-content .modal-header {
        border-bottom: none;
    }
    #book-appointment .modal-dialog .modal-content .modal-header .modal-title {
        display: flex;
        justify-content: center;
        align-items: center;
        font-weight: 600;
        font-size: 18px;
        color: #473c38;
        letter-spacing: 1px;
        line-height: 24px;
    }
    #book-appointment .modal-dialog .modal-content .modal-body {
        display: flex;
        flex-wrap: wrap;

    }
    #book-appointment .modal-dialog .modal-content .modal-body .form-group {
        margin-left: 7.5px;
        margin-right: 7.5px;
        min-width: calc(100% - 15px);
    }
    @media (min-width: 541px) {
        #book-appointment .modal-dialog .modal-content .modal-body > *:not(:last-child) {
            flex: 1 1 auto;
            min-width: calc(50% - 15px);
        }
    }
    #book-appointment .modal-dialog .modal-content .modal-body > *:last-child {
        min-width: calc(100% - 15px);
    }
    #book-appointment .modal-dialog .modal-content .modal-body .form-group input,
    #book-appointment .modal-dialog .modal-content .modal-body .form-group select,
    #book-appointment .modal-dialog .modal-content .modal-body .form-group textarea {
        font-weight: 500;
        font-size: 12px;
        color: #473c38;
        letter-spacing: 1px;
        line-height: 22px;
    }
    #book-appointment .modal-dialog .modal-content .modal-body .form-group input::placeholder,
    #book-appointment .modal-dialog .modal-content .modal-body .form-group select::placeholder,
    #book-appointment .modal-dialog .modal-content .modal-body .form-group textarea::placeholder {
        font-weight: 500;
        font-size: 12px;
        color: #888888;
        letter-spacing: 1px;
        line-height: 22px;
    }
    #book-appointment .modal-dialog .modal-content .modal-body .form-group .text-danger,
    #book-appointment .modal-dialog .modal-content .modal-footer .text-danger {
        font-weight: 500;
        font-size: 10px;
        color: #a94442;
        letter-spacing: 1px;
        line-height: 22px;
    }
    #book-appointment .modal-dialog .modal-content .modal-footer {
        padding: 0px;
        border-top: none;
    }
    .fc-day-grid-container {
        height: auto !important;
    }
</style>