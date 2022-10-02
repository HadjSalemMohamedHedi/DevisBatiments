/*
 *	jQuery FullCalendar Extendable Plugin
 *	An Ajax (PHP - Mysql - jquery) script that extends the functionalities of the fullcalendar plugin
 *  Dependencies: 
 *   - jquery
 *   - jquery Ui
 *   - jquery Fullcalendar
 *   - Twitter Bootstrap
 *  Author: Paulo Regina
 *  Website: www.pauloreg.com
 *  Contributions: Patrik Iden, Jan-Paul Kleemans, Bob Mulder
 *	Version 1.5.8 [Bootstrap 3.X just removed input-block-level to form-control], May - 2014
 *	Released Under Envato Regular or Extended Licenses
 */
 
(function($, undefined) 
{

	$.fn.extend 
	({

		// FullCalendar Extendable Plugin
		FullCalendarExt: function(options) 
		{	
			var lien= '?event=call';
		
		 var val_filter= $('input.icheck-custom').attr('value');
		 
	    if(val_filter=='commercial'){
			
		var id_commercial = $("#id_commercial_search").val();	
		if(id_commercial){
			lien += "&id_commercial="+id_commercial;
			//alert(lien);
		}}
		
		 if(val_filter=='responsable'){
			
		var responsable = $("#id_responsable_search").val();	
		if(id_responsable){
			lien += "&id_responsable="+id_responsable;
			//alert(lien);
		}}
		
		var id_event = $("#id_event").val();
		if(id_event){
			lien += "&id_event="+id_event;
			//alert(lien);
		}
		var start = $("#start").val();
		if(start){
			lien += "&d_start="+start;
		}
		var end = $("#end").val();
		if(end){
			lien += "&d_end="+end;
		}
		
		var statut = $("#statut").val();
		if(statut){
			lien += "&statut="+statut;
		}

			// Default Configurations
            var defaults = 
			{
				calendarSelector: '#calendar',
				
				timeFormat: 'H:mm - {H:mm}',
				
				ajaxJsonFetch: 'js/calandrie/includes/cal_events.php'+lien,
				ajaxUiUpdate: 'js/calandrie/includes/cal_update.php',
				ajaxEventSave: 'js/calandrie/includes/cal_save.php',
				ajaxEventQuickSave: 'js/calandrie/includes/cal_quicksave.php',
				ajaxEventDelete: 'js/calandrie/includes/cal_delete.php',
				ajaxEventEdit: 'js/calandrie/includes/cal_edit_update.php',
				ajaxEventExport: 'js/calandrie/includes/cal_export.php',
				
				modalViewSelector: '#cal_viewModal',
				modalEditSelector: '#cal_editModal',
				modalQuickSaveSelector: '#cal_quickSaveModal',
				formAddEventSelector: 'form#add_event',
				formFilterSelector: 'form#filter-category select',
				formSearchSelector: 'form#search',
				formEditEventSelector: 'form#edit_event', // php version
				
				successAddEventMessage: 'Successfully Added Event',
				successDeleteEventMessage: 'Successfully Deleted Event',
				successUpdateEventMessage: 'Successfully Updated Event',
				failureAddEventMessage: 'Failed To Add Event',
				failureDeleteEventMessage: 'Failed To Delete Event',
				failureUpdateEventMessage: 'Failed To Update Event',
				
				visitUrl: 'Visit Url:',
				titleText: 'Title:',
				descriptionText: 'Description:',
				categoryText: 'Category:',
				
				defaultColor: '#587ca3',
								
				monthNames: ['Janvier','Février','Mars','Avril','Mai','Juin','Juillet','Août','Septembre','Octobre','Novembre','Décembre'],
				monthNamesShort: ['Jan','Fév','Mar','Avr','Mai','Jui','Juil','Aoû','Sep','Oct','Nov','Déc'],
				dayNames: ['Dimanche','Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi'],
				dayNamesShort: ['Dim','Lun','Mar','Mer','Jeu','Ven','Sam'],
				today: 'today',
				month: 'Mois',
				week: 'Semaine',
				day: 'Jour',
				
				weekType: 'agendaWeek', // basicWeek
				dayType: 'agendaDay', // basicDay
				
				editable: false,
				disableDragging: false,
				disableResizing: false,
				ignoreTimezone: false,
				lazyFetching: true,
				filter: true,
				quickSave: true,
				firstDay: 1,
				
				gcal: false,
				
				version: 'modal',
				
				quickSaveCategory: '',
				
				savedRedirect: 'calendar.php?save=ok',
				removedRedirect: 'calendar.php?delete=ok',
				updatedRedirect: 'calendar.php?modif=ok'  
            }

			var options =  $.extend(defaults, options);
			
			var opt = options;
						
			if(opt.version == 'modal' && opt.gcal == false)
			{
			// fullCalendar
			$(opt.calendarSelector).fullCalendar
			({
				lang: 'fr',
				timeFormat: opt.timeFormat,
				timezone : 'local',
				header: 
				{
						left: 'prev,next',
						center: 'title',
						right: 'month,'+opt.weekType+','+opt.dayType	

				},
				monthNames: opt.monthNames,
				monthNamesShort: opt.monthNamesShort,
				dayNames: opt.dayNames,
				dayNamesShort: opt.dayNamesShort,
				buttonText: {
					today: opt.today,
					month: opt.month,
					week: opt.week,
					day: opt.day
				},
				editable: opt.editable,
				disableDragging: opt.disableDragging,
				disableResizing: opt.disableResizing,
				ignoreTimezone: opt.ignoreTimezone,
				firstDay: opt.firstDay,
				lazyFetching: opt.lazyFetching,
				selectable: opt.quickSave,
				selectHelper: opt.quickSave,
				select: function(start, end, allDay) 
				{
					calendar.quickModal(start, end, allDay);
					$(opt.calendarSelector).fullCalendar('unselect');
				},
				eventSources: [{url: opt.ajaxJsonFetch, allDayDefault: false}],
				eventDrop: 
					function(event) 
					{ 
						$.post(opt.ajaxUiUpdate, event, function(response) {
							// just update $(opt.calendarSelector).fullCalendar('refetchEvents');
						});
					},
				eventResize:
					function(event) 
					{ 
						$.post(opt.ajaxUiUpdate, event, function(response){
							// just update $(opt.calendarSelector).fullCalendar('refetchEvents');
						});
					},
				eventRender: 
					function(event, element) 
					{	
						element.attr('data-toggle', 'modal');
						element.attr('onclick', 'calendar.openModal("' + event.title + '","' + escape(event.description) + '","' + event.url + '","' + event.id + '","' + event.start + '","' + event.end + '");');  	
					}	
				}); //fullCalendar
				
				 // Function to Open Modal
				calendar.openModal = function(title, description, url, id, eStart, eEnd)
				{
					 calendar.title = title;
					 calendar.description = description;
					 calendar.url = url;
					 calendar.id = id;
					 
					 calendar.eventStart = eStart;
					 calendar.eventEnd = eEnd;
					  					  
					  if(calendar.url === 'undefined') 
					  {
					  	$(".modal-body").html(unescape(calendar.description)); 
					  } else {
					  	$(".modal-body").html(unescape(calendar.description)+'<br /><br />'+opt.visitUrl+' <a href="'+calendar.url+'">'+calendar.url+'</a>'); 	  
					  }
					  
					  $(".modal-header").html('<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>'+'<h4>'+calendar.title+'</h4>'); 
					  
					  $(opt.modalViewSelector).modal('show');
		
					  	// Edit Button
						$(".modal-footer").delegate('[data-option="edit"]', 'click', function(e) 
						{
							$(opt.modalViewSelector).modal('hide');
							
							if(calendar.url === 'undefined') {
								$(".modal-header").html('<form id="event_title_e"><button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button><label>'+opt.titleText+' </label>'+'<input type="text" class="form-control" name="title_update" value="'+calendar.title+'"></form>');
								$(".modal-body").html('<form id="event_description_e"><label>'+opt.descriptionText+' </label>'+'<textarea class="form-control" name="description_update">'+unescape(calendar.description)+'</textarea></form>');
							} else {
								$(".modal-header").html('<form id="event_title_e"><button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button><label>'+opt.titleText+' </label>'+'<input type="text" class="form-control" name="title_update" value="'+calendar.title+'"></form>');
								$(".modal-body").html('<form id="event_description_e"><label>'+opt.descriptionText+' </label>'+'<textarea class="form-control" name="description_update">'+unescape(calendar.description)+'</textarea><label>Url: </label>'+'<input type="text" class="form-control" name="url_update" value="'+calendar.url+'"></form>');	
							}
							
							$(opt.modalEditSelector).modal('show'); 
							
							  // On Modal Hidden
							 $(opt.modalEditSelector).on('hidden', function() {
								//$(opt.calendarSelector).fullCalendar('refetchEvents'); (by uncommenting this fixes multiply loads bug)
							 })
							 
							 // Close Button - This is due cache to prevent data being saved on another view
							 $(".modal-footer").delegate('[data-dismiss="modal"]', 'click', function(e) 
							 {
								 //$(opt.calendarSelector).fullCalendar('refetchEvents'); (by uncommenting this fixes multiply loads bug)
								 e.preventDefault();
							 });
						 	 
							e.preventDefault();
						});
				} // openModal
				
				// After all step above save
			    // Update button
				$(".modal-footer").delegate('[data-option="save"]', 'click', function(e) 
				{	
					var event_title_e = $("form#event_title_e").serializeArray(); 
					var event_description_e = $("form#event_description_e").serializeArray();
					var event_url = $("form#event_description_e").serializeArray();
					
					calendar.update(calendar.id, event_title_e[1], event_description_e, event_url);
					
					e.preventDefault();
				});
					
				// Delete button
				$(".modal-footer").delegate('[data-option="remove"]', 'click', function(e) 
				{
					calendar.remove(calendar.id);	
					e.preventDefault();
				 });
				 
				 // Export button
				$(".modal-footer").delegate('[data-option="export"]', 'click', function(e) 
				{
					calendar.exportIcal(calendar.id, calendar.title, calendar.description, calendar.eventStart, calendar.eventEnd, calendar.url);	
					e.preventDefault();
				 });
										
				// Function to quickModal
				calendar.quickModal = function(start, end, allDay)
				{
					$(".modal-header").html('<form id="event_title"><button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button><label>'+opt.titleText+' </label>'+'<input type="text" class="form-control" name="title" value=""></form>');
					
					$(".modal-body").html('<form id="event_description"><label>'+opt.descriptionText+' </label>'+'<textarea class="form-control" name="description"></textarea>'+opt.quickSaveCategory+'</form>');
						
					$(opt.modalQuickSaveSelector).modal('show');
					
					calendar.start = start;
					calendar.end = end;
					calendar.allDay = allDay;
					
					// Save button
					$(".modal-footer").delegate('[data-option="quickSave"]', 'click', function(e) 
					{	
						var event_title = $("form#event_title").serialize();
						var event_description = $("form#event_description").serialize();
						
						calendar.quickSave(event_title, event_description, calendar.start, calendar.end, calendar.allDay);
						
						e.preventDefault();
					});
					
					e.preventDefault();

				} // end quickModal
					
				// Function quickSave 
				calendar.quickSave = function(event_title, event_description, start, end, allDay)
				{
					var start_factor = $.fullCalendar.formatDate(start, 'yyyy-MM-dd');
					var startTime_factor = $.fullCalendar.formatDate(start, 'HH:mm');
					var end_factor = $.fullCalendar.formatDate(end, 'yyyy-MM-dd');
					var endTime_factor = $.fullCalendar.formatDate(end, 'HH:mm');
					var constructor = 'title='+event_title+'&description='+event_description+'&start_date='+start_factor+'&start_time='+startTime_factor+'&end_date='+end_factor+'&end_time='+endTime_factor+'&url=false&color='+opt.defaultColor+'&allDay='+allDay;
					$.post(opt.ajaxEventQuickSave, constructor, function(response) 
					{				
						if(response == 1 || response == '' || response == true) 
						{
							$(opt.modalQuickSaveSelector).modal('hide');
							$(opt.calendarSelector).fullCalendar('refetchEvents');
						} else {
							alert(response);	
						}
					});	
					e.preventDefault();
				} // end quickSave
					   
				// Function to Save Data to the Database 
				calendar.save = function()
				{
					$(opt.formAddEventSelector).on('submit', function(e)
					{
						$.post(opt.ajaxEventSave, $(this).serialize(), function(response) 
						{
							if(response == 1) 
							{
								document.location.reload();
							} else {
								alert(opt.failureAddEventMessage);
							}
							
						});	
						e.preventDefault();
					}); 
				};
					
				// Function to Remove Event ID from the Database
				calendar.remove = function(id)
				{
					var construct = "id="+id;
					
					$.post(opt.ajaxEventDelete, construct, function(response) 
					{
						if(response == '') 
						{
							$(opt.modalViewSelector).modal('hide');
							$(opt.calendarSelector).fullCalendar('refetchEvents');
						} else {
							alert(opt.failureDeleteEventMessage);
						}
					});	
				};
					
				// Function to Update Event to the Database
				calendar.update = function(id, title, description, url)
				{
					if(calendar.url === 'undefined') {
						var construct = "id="+id+"&title="+title.value+"&description="+description[1].value;	
					} else {
						var construct = "id="+id+"&title="+title.value+"&description="+description[2].value+'&url='+url[3].value;		
					}
					
					$.post(opt.ajaxEventEdit, construct, function(response) 
					{
						if(response == '') 
						{
							$(opt.modalEditSelector).modal('hide');
							$(opt.calendarSelector).fullCalendar('refetchEvents');
						} else {
							alert(opt.failureUpdateEventMessage);	
						}
					});	
				}
				
				// Function to Export Calendar
				calendar.exportIcal = function(expID, expTitle, expDescription, expStart, expEnd, expUrl)
				{ 
					var start_factor = $.fullCalendar.formatDate($.fullCalendar.parseDate(expStart), 'yyyy-MM-dd HH:mm:ss');
					var end_factor = $.fullCalendar.formatDate($.fullCalendar.parseDate(expEnd), 'yyyy-MM-dd HH:mm:ss');
					
					var construct = 'method=export&id='+expID+'&title='+expTitle+'&description='+expDescription+'&start_date='+start_factor+'&end_date='+end_factor+'&url='+expUrl;	

					$.post(opt.ajaxEventExport, construct, function(response) 
					{
						
						$(opt.modalViewSelector).modal('hide');
						window.location = 'js/calandrie/includes/Event-'+expID+'.ics';
						var construct2 = 'id='+expID;
						$.post(opt.ajaxEventExport, construct2, function() {});
					});
				}
					
			} else {
						
				if(opt.gcal == true) { opt.weekType = ''; opt.dayType = ''; }
				
				// php view mode fullcalendar
				$(opt.calendarSelector).fullCalendar
				({
					timeFormat: opt.timeFormat,
					header: 
					{
						left: 'prev,next',
						center: 'title',
						right: 'month,'+opt.weekType+','+opt.dayType
					},
					monthNames: opt.monthNames,
					monthNamesShort: opt.monthNamesShort,
					dayNames: opt.dayNames,
					dayNamesShort: opt.dayNamesShort,
					buttonText: {
						today: opt.today,
						month: opt.month,
						week: opt.week,
						day: opt.day
					},
					editable: opt.editable,
					nowIndicator: true,
					disableDragging: opt.disableDragging,
					disableResizing: opt.disableResizing,
					ignoreTimezone: opt.ignoreTimezone,
					firstDay: opt.firstDay,
					eventSources: [{url: opt.ajaxJsonFetch, allDayDefault: false}],
					
					eventRender: function(event, element, view) {
						
						var id_event = event.id;
						
						var d = new Date(event.start);
						var h = d.getHours()-1; // => 9
						var m = d.getMinutes(); // =>  30
						if(m<10){
							m = '0'+m;
						}
						
						var d2 = new Date(event.end);
						var h2 = d2.getHours()-1; // => 9
						var m2 = d2.getMinutes(); // =>  30
						if(m2<10){
							m2 = '0'+m2;
						}
						var title =  event.title;
						
						if(event.description==''){
							desc = "Pause  "+h+':'+m+'-'+h2+':'+m2+'';
						}else{
							desc = event.description
						}
						
												
						$(element).find('span:nth-child(1)').html(' '+h+':'+m+'-'+h2+':'+m2+' ');
						
						$(element).find('span:nth-child(2)').html(title);
						
						$(element).addClass('cursor');
						
						$(element).removeAttr('href');
						
						$(element).attr('onclick', 'Editevent('+id_event+');');
						
						
						
						/**/
						if(event.statut == 3){
							var img = "./imgs/r.png";
							
						}else if(event.statut == 0){
							var img = "./imgs/o.png";
						}else if((event.statut == 1) || (event.statut == 2)){
							var img = "./imgs/v.png";
						}
						if(img){
							$(element).find('span:nth-child(1)').prepend('<img data-id="" width="14" src="'+img+'" />');
						}
						
						$(element).find('span:nth-child(1)').prepend('<!--<i class="fa fa-square border" style="color:'+event.color2+';"></i>-->');
						
						var today = new Date();
						if (d < today) {
							$(element).css("opacity", "0.5");
						}
						
						$(element).css('border', '2px solid white');
						
						
						//$(element).find('.fc-title').text(JSON.stringify(event)); 
						//rgba(150,150,150, 0.5)
						/**/
						
						
					},
					eventAfterRender: function(event, element) {
						
						var d = new Date(event.start);
						var h = d.getHours()-1; // => 9
						var m = d.getMinutes(); // =>  30
						if(m<10){
							m = '0'+m;
						}
						
						var d2 = new Date(event.end);
						var h2 = d2.getHours()-1; // => 9
						var m2 = d2.getMinutes(); // =>  30
						if(m2<10){
							m2 = '0'+m2;
						}
						
						
						
						var text = "<h3>"+h+':'+m+'-'+h2+':'+m2+"</h3>";
						
						text += "<br><h4 style='margin: 0px;'><b>"+event.title+"</b></h4>";
						text += "<br> <b style='font-size: 13px;'>Description:</b><br> "+event.description;
						text += "<br> <b style='font-size: 13px;'>Commentaire commerciale:</b><br> "+event.comment;
						text += "<br> <b style='font-size: 13px;'>Client:</b><br> "+event.client;
						var statut_text;
						switch (event.statut) {
							case '0':statut_text='En cours';break;
							case '1':statut_text='Confirmé';break;
							case '2':statut_text='Validé';break;
							case '3':statut_text='Annulé';break;
							case '4':statut_text='';break;
							case '5':statut_text='A repositionner';break;
							case '6':statut_text='RDV Perso';break;
						}
						text += "<br> <b style='font-size: 13px;'>Statut:</b> "+statut_text;
						element.qtip({
							content: text,
							position: {
								 target: 'mouse', // Use the mouse position as the position origin
								 adjust: {
									 // Don't adjust continuously the mouse, just use initial position
									 mouse: false
								 } 
							 },
							hide: {
								fixed: true,
                				delay: 300,
								 
							 }
						});
					},
					 //viewRender:function(view,element){
						 
						// try {
						//	setTimeline();
						//} catch(err) {}
						 
       					  //defaultView:'basicDay';
    				//},
					//dayRender: function (date, cell) {
						//JSON.stringify(cell);
						//var today = new Date();
						
						//cell.text(date);
						
						
						//if (date < today) {
							//cell.css("opacity", "0.5");
						//}
					//},
					eventDrop: 
						function(event) 
						{ 
							$.post(opt.ajaxUiUpdate, event, function(response){
								// success, its ajax so no visible response
							});
						},
					eventResize:
						function(event) 
						{ 
							$.post(opt.ajaxUiUpdate, event, function(response){
								// success, its ajax so no visible response
							});
						}
				}); // fullcalendar
				
				


				function strTimeToMinutes(str_time) {
				  var arr_time = str_time.split(":");
				  var hour = parseInt(arr_time[0]);
				  var minutes = parseInt(arr_time[1]);
				  return((hour * 60) + minutes);
				}
				
				// php view mode Function to Save Data to the Database 
				calendar.save = function()
				{
					$(opt.formAddEventSelector).on('submit', function(e)
					{
						$.post(opt.ajaxEventSave, $(this).serialize(), function(response) 
						{
							if(response == 1) 
							{
								window.location = opt.savedRedirect;
							} else {
								alert(opt.failureAddEventMessage);	
							}
							
						});	
						e.preventDefault();
					}); 
				};
				
				// php view mode Function to Remove Event ID from the Database
				calendar.remove = function(id)
				{
					var construct = "id="+id;
					
					$.post(opt.ajaxEventDelete, construct, function(response) 
					{
						if(response == '') 
						{
							
							window.location = opt.removedRedirect;
						} else {
							alert(opt.failureDeleteEventMessage);
						}
					});	
				};
				
				calendar.update = function(id)
				{
					var construct = $(opt.formEditEventSelector).serialize()+"&id="+id;
				
					$(opt.formEditEventSelector).on('submit', function(e) 
					{
						$.post(opt.ajaxEventEdit, construct, function(response) 
						{
							if(response == '') {
								// alert(opt.successUpdateEventMessage);
								window.location = opt.updatedRedirect;
							} else {
								alert(opt.failureUpdateEventMessage);
							}
							
						});	
						e.preventDefault();
					});  
				};
						
			} // if condition
			
			// Commons - modal + phpversion
			// Fiter
			if(opt.filter == true)
			{
				$(opt.formFilterSelector).on('change', function(e) 
				{
					 selected_value = $(this).val();
					 
					 construct = 'filter='+selected_value;
					 
					 $.post('js/calandrie/includes/loader.php', construct, function(response) 
					{
						$(opt.calendarSelector).fullCalendar('refetchEvents');
					});	
					 
					 e.preventDefault();  
				});
			}
			
			// Commons - modal + phpversion
			// Search Form
			if(opt.filter == true)
			{
				// keypress
				$(opt.formSearchSelector).keypress(function(e) 
				{
					if(e.which == 13)
					{
						search_me();
						e.preventDefault();
					}
				});
				
				// submit button
				$(opt.formSearchSelector+' button').on('click', function(e) 
				{
					search_me();
				});
				
				function search_me()
				{
					 value = $(opt.formSearchSelector+' input').val();
					 
					 construct = 'search='+value;
					 
					 $.post('js/calandrie/includes/loader.php', construct, function(response) 
					{
						$(opt.calendarSelector).fullCalendar('refetchEvents');
					});		
				}
			}
		   
		} // FullCalendar Ext
		
	}); // fn
	 
})(jQuery);

// define object at end of plugin to fix ie bug
var calendar = {};