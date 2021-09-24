if (window.jQuery) {
	jQuery(
		function($) {
		
			/* Utility function to get data for AJAX calls */
			function getData(element, keys) {
				var data = {},
					k, d, ds,
					$e = $(element),
					is, cl;
					
				if (keys.constructor === Object) {
					for (k in keys) {
						if (keys.hasOwnProperty(k)) {
							d = 'data-' + k;
							ds = '[' + d + ']';
							is = $e.is(ds);
							cl = is ? false : $e.closest(ds).length > 0;
							
							if (is || cl) {
								data[k] = is ? $e.attr(d) : $e.closest(ds).attr(d);
								if (keys[k] === true) data[k] |= 0;
							}
						}
					}
				}
				return data;
			}		
		
			/* AJAX save inventory */
			$('#inventory').on(
				'click',
				'a',
				function(e) {
					if (this.hash !== '#save') return;
					e.preventDefault();
					var $input = $('input', $(this).parent()),
						data = getData($input, {storeid: true, itemno: true, mode: false});
					$(this).attr('data-icon-before', 'N');
					data.amount = $input.val() | 0;
					$.ajax(
						'/ajax/updateinventory.php',
						{
							dataType: 'json',
							type: 'POST',
							data: data,
							context: this,
							success: function(json) {
								$(this).attr('data-icon-before', json.ok && json.ok === true ? 'P' : '4');
							},
							error: function(json) {
								$(this).attr('data-icon-before', '4');
							}
						}
					);
				}
			)
           
           
			.on(
				'focus',
				'input',
				function() {
					$('a', $(this).parent()).attr('data-icon-before', '3');
				}
			)
      
			.on(
				'submit',
				false
			);
		
			/* Toggle location coordinators */
			$('#helpmenow .box').each(
				function() {
					$('<a href="#toggle">Hide location coordinator</a>')
						.on(
							'click',
							function(e) {
								e.preventDefault();
								var show = $(this).text().substr(0, 5) === 'Show ';
								$(this)
									.text($(this).text().replace(show ? /^Show/ : /^Hide/, show ? 'Hide' : 'Show'))
									.parent()
									.next('.box')
									.toggle();
								return false;
							}
						)
						.appendTo($(this).prev())
						.click();
				}
			);
		
			/* Tabs */
			if ($('.tabs').length > 0) {
				$('.tabs').each(
					function(tabsetno) {
						var $tabs = $(this)
							tabcount = 0;
						$('a', this).each(
							function(i) {
								i === 0 ? $(this).addClass('active') : $(this.hash).hide();
								$(this.hash).addClass('tabbody-' + tabsetno);
								tabcount++;
							}
						);
						$tabs
							.addClass('tabsenabled tabs' + tabcount)
							.on(
								'click',
								'a',
								function(e) {
									e.preventDefault();
									$('.tabbody-' + tabsetno).hide();
									$(this.hash).show();
									$(this).closest('ul').find('a').removeClass('active');
									$(this).addClass('active');
									return false;
								}
							);
					}
				);
			}

			/* FAQs */
			if ($('#faq').length > 0) {
				$('#faq').addClass('accordian');
				$('.faq').each(
					function() {
						var $h3 = $('h3', this);
						$h3.html('<a href="#toggle">' + $h3.text() + '</a>');
					}
				);
				$('#faq').on(
					'click',
					'h3 a',
					function(e) {
						e.preventDefault();
						$('#faq .open').removeClass('open');
						$(this).closest('.faq').addClass('open');
						return false;
					}
				);
			}
             
			 
			 
			 
			/* Placements form */
			if ($('#placements').length > 0) {
				$('#placements')
					.on(
						'submit',
						function (e) {
							if ($('#locationid')[0].selectedIndex === 0) {
								alert('Per favore scegliere la postazione');
								return false;
							}
							if (($('#magazines').val() | 0) + ($('#books').val() | 0) + ($('#bibles').val() | 0) + ($('#brochures').val() | 0)  + ($('#s43').val() | 0) + ($('#studies').val() | 0) + ($('#videos').val() | 0) + ($('#hours').val() | 0) + ($('#pio').val() | 0) + ($('#disf').val() | 0) + ($('#inactive').val() | 0)  === 0) {
								alert('Non è stato inserito nessun dato');
								return false;
							}
						}
					)
					.on(
						'change',
						'select',
						function (e) {
							var date = $('#date').val(),
								locationid = $('#locationid').val(),
								$form = $(this).closest('form');
							$('.msg', $form).remove();
							if (recentplacements && recentplacements[date] && recentplacements[date][locationid]) {
								$('#magazines').val(recentplacements[date][locationid].magazines);
								$('#magloc').val(recentplacements[date][locationid].magloc);
								$('#books').val(recentplacements[date][locationid].books);
								$('#boloc').val(recentplacements[date][locationid].boloc);
								$('#bibles').val(recentplacements[date][locationid].bibles);
								$('#biloc').val(recentplacements[date][locationid].biloc);
								$('#brochures').val(recentplacements[date][locationid].brochures);
								$('#brloc').val(recentplacements[date][locationid].brloc);
								$('#s43').val(recentplacements[date][locationid].s43);
								$('#studies').val(recentplacements[date][locationid].studies);
								$('#videos').val(recentplacements[date][locationid].videos);
								$('#hours').val(recentplacements[date][locationid].hours);
								$('#pio').val(recentplacements[date][locationid].pio);
								$('#disf').val(recentplacements[date][locationid].disf);
								$('#inactive').val(recentplacements[date][locationid].inactive);
								$form.prepend('<p class="msg" data-icon-before="S">Dati già registrati per questa data.</p>');
							} else {
								$('#magazines').val(0);
								$('#magloc').val(0);
								$('#books').val(0);
								$('#boloc').val(0);
								$('#bibles').val(0);
								$('#biloc').val(0);
								$('#brochures').val(0);
								$('#brloc').val(0);
								$('#s43').val(0);
								$('#studies').val(0);
								$('#videos').val(0);
								$('#hours').val(0);
								$('#pio').val(0);
								$('#disf').val(0);
								$('#inactive').val(0);
							}
						}
					);
				
			}

			/* Training form */
			if ($('#trainingform').length > 0) {
				$('#trainingform input[type=checkbox]').on(
					'change',
					function() {
						$('.rad').toggle(!this.checked);
					}
				)
				.triggerHandler('change');
			}

			/* Quick filter in publisher menu */
			if ($('.publisherfilter').length > 0) {
				$('.publisherfilter')
					.on(
						'keyup',
						'input[type=search]',
						function (e) {
							e.stopPropagation();
						}
					)
					.on(
						'search',
						'input[type=search]',
						function (e) {
							var $li = $(this).closest('nav').find('li'),
								q = this.value;
							if (String(this.value).length >= 3) {
								$li.each(
									function () {
										var email = $(this).attr('data-email'),
											mobilephone = $(this).attr('data-mobilephone'),
											homephone = $(this).attr('data-homephone'),
											name = String($(this).text()).substr(4),
											regexp = new RegExp(q, 'i');
										if (regexp.test(email) || regexp.test(mobilephone) || regexp.test(homephone) || regexp.test(name)) {
											$(this).removeClass('hidden');
										} else {
											$(this).addClass('hidden');
										}
									}
								);
							} else {
								$li.removeClass('hidden');
							}
						}
					)
					.on(
						'submit',
						false
					);
			}

			/* Quick jump in lists */
			if ($('#top').length) {
				$(document).on(
					'keyup',
					function(e) {
						if (e.which >= 65 && e.which <= 90) {
							var letter = String.fromCharCode(e.which);
							location.hash = '#' + letter;
						}
					}
				);
			}
			
			/* Admin publisher form */
			if ($('#appointed').length) {
				$('#gender').on(
					'change',
					function () {
						$('#appointed').toggle($(this).val() === 'Bro');
					}
				)
				.triggerHandler('change');
			}
			
			/* Only set if email exists */
			if ($('#token').length > 0) {
				var $token = $('#token');

				/* New pioneer email */
				$(' <a href="#">Invia email di Benvenuto</a> ')
					.on(
						'click',
						function (e) {
		/* old istruction:	if (confirm('Are you sure you want to send a welcome email and text? This will incur a charge.')) {*/
							if (confirm('Sei sicuro di voler spedire questa email?')) {
								var self = this,
									publisherid = location.search.match(/publisherid=\d+/)[0].split('=')[1],
									fail = function (error) {
										$(self).replaceWith(' Email non spedita ' + (error ? ' - ' + error.toString() : ''));
									};
								$.getJSON(
									"/ajax/newpioneer.php?publisherid=" + publisherid
								)
								.done(
									function (json) {
										if (json.error) {
											fail(json.error);
										} else if (json.emailok && json.emailok === true) {
											$(self).replaceWith(' Email inviata ' + (json.smsok && json.smsok === true ? 'e' : 'ma non') + ' spedito SMS');
										}
									}
								)
								.fail(fail);
							}
							return false;
						}
					)
					.insertAfter($token);

				
				/* Show / hide token */
				$(' <a href="#" style="display:inline-block;margin:0 1rem">Mostra token</a> ')
					.on(
						'click',
						function (e) {
							$token.toggle();
							$(this).text($(this).text() === 'Mostra token' ? 'Nascondi token' : 'Mostra token');
							return false;
						}
					)
					.insertAfter($token);
				$token.hide();
			}
			
			/* Unlock account link */
			$(document).on(
				'click',
				'.ajaxwrapper a',
				function(e) {
					e.preventDefault();
					$.ajax(
						this.href,
						{
							dataType: 'json',
							type: 'GET',
							context: $(this).closest('.ajaxwrapper')
						}
					)
					.done(
						function(json) {
							if (json.ok && json.ok === true) {
								$(this).remove();
							} else {
								$(this).replaceWith(' - errore nello sblocco utente ');
							}
						}
					);
					return false;
				}
			)
			
			/* Maps */
			if (window.google && $('#map').length > 0) { // Maps
				var $map = $('#map'),
					latlng = $.parseJSON($map.attr('data-latlng')),
					storelatlng = [],
					map,
					center = new google.maps.LatLng(latlng[0][0], latlng[0][1]),
					marker,
					bounds = new google.maps.LatLngBounds(),
					boundchange,
					i;
				map = new google.maps.Map(
					$map[0], 
					{
						draggable: false,
						zoom: 15,
						center: center,
						mapTypeId: google.maps.MapTypeId.ROADMAP
					}
				); 
				
				/* Trolley locations */
				for (i = 0; i < latlng.length; i++) {
					marker = new google.maps.Marker(
						{
							position: new google.maps.LatLng(latlng[i][0], latlng[i][1]),
							map: map,
							title: $map.attr('data-name'),
							icon: '/images/group.png'
						}
					);
					bounds.extend(new google.maps.LatLng(latlng[i][0], latlng[i][1]));
				}
				
				/* Store locations */
				$('.store').each(
					function() {
						var $this = $(this);
						marker = new google.maps.Marker(
							{
								position: new google.maps.LatLng($this.attr('data-lat'), $this.attr('data-lng')),
								map: map,
								title: $this.attr('data-name'),
								icon: '/images/cabin.png'
							}
						);
						bounds.extend(new google.maps.LatLng($this.attr('data-lat'), $this.attr('data-lng')));
					}
				);
				
				boundchange = google.maps.event.addListener((map), 'bounds_changed', function(e) {
					if (this.getZoom() > 17) this.setZoom(17);
					google.maps.event.removeListener(boundchange);
				});
				
				map.fitBounds(bounds);
				map.setCenter(bounds.getCenter());
								
			}
			
			/* Lookup */

/*
			if ($('#lookup').length > 0) {
				$('#lookup').on(
					'submit',
					function(e) {
						e.preventDefault();
						$.ajax(
							'/ajax/lookup.php',
							{
								data: {
									q: $('#q').val()
								},
								dataType: 'json',
								type: 'POST',
								context: this
							}
						)
						.done(
							function(json) {
								var i,
									$li = $('> ul > li:last', this),
									html = [];
								if (json.ok === true) {
									for (i = 0; i < json.details.length; i++) {
										html.push(
											'<p><strong>Name:</strong> ',
											json.details[i].gender,
											' ',
											json.details[i].firstname,
											' ',
											json.details[i].lastname,
											'; <strong>Congregation:</strong> ',
											json.details[i].congregation,
											'</p>',
											'<p>',
											'<strong>Email:</strong> ',
											json.details[i].email,
											'</p>',
											'<p>',
											'<strong>Mobile:</strong> ',
											json.details[i].mobilephone,
											'</p>'
										);
									}
									$li.html(html.join(''));
								}
							}
						);
						return false;
					}
				);
			}
*/
			
			/* Enable accordian folding for schedule display on small screens only */
			if ($('#schedulelist').length > 0) {
				var $s = $('#schedulelist');
				$('h3', $s).addClass('button');
				$('> li > div', $s).addClass('smallscreenhide');
				$s.on(
					'click',
					'h3',
					function(e) {
						if ($(this).next('div:hidden').length > 0) {
							$('> li > div', $s).addClass('smallscreenhide');
							$(this).next('div:hidden').removeClass('smallscreenhide');
						} else {
							$(this).next('div:visible').addClass('smallscreenhide');
						}
					}
				);
			}
			
			/* Report detail toggle */
			
			$('.detailtoggle')
				.on(
					'click',
					'> li',
					function(e) {
						$('> ul', this).toggle();
					}
				)
				.before('<p>Click headings to expand / collapse</p>')
				.find('> li')
				.click();
			
			/* AJAX updating */
			
			if ($('#shifts').length > 0) {
				$('#shifts').on(
					'click',
					'a.button',
					function(e) {
						var $li = $(this).closest('li');
						if ($li.data('ajaxing') === true) return false;
						e.preventDefault();
						var data = getData(this, {publisherid: true, date: false, sessionid: true, allocationid: true, accept: false});
						$(this).closest('li').data('ajaxing', true).find('a').addClass('working');
						$.ajax(
							'/ajax/acceptdeclineshift.php',
							{
								data: data,
								dataType: 'json',
								type: 'POST',
								context: this
							}
						)
						.done(
							function(json) {
								if (data.accept !== 'd') {
									$.ajax(
										'/ajax/updateshiftdetails.php',
										{
											data: data,
											dataType: 'html',
											type: 'POST',
											context: this
										}
									)
									.done(
										function(html) {
											$(this)
												.closest('li')
												.replaceWith(html);
										}
									)
								} else {
									location.reload(true);
								}
							}
						);
					}
				);
			}
			
			if ($('.schedule').length > 0) {
			
				$(document).on(
					'keyup',
					function(e) {
						if (e.which === 27) {
							$('#lightbox').remove();
						}
					}
				);

				$('.schedule').on(
					'dblclick',
					'[data-publisherid]',
					function(e) {
						if ($('#lightbox').length > 0) return false;
						var $this = $(this),
							data = getData(this, {publisherid: true, day: false, date: false, sessionid: true, locationid: true, allocationid: true, confirmed: true, notes: false, subst: false, posid: true}),
							template = $('#template')[0].innerHTML;
							//alert('Please check data: '+JSON.stringify(data));
						$(template).appendTo('body');
						$('#lightbox')
							.attr('data-slot-data', JSON.stringify(data))
							.find('#confirmed')
							.prop('checked', !!data.confirmed)
							.end()
							.find('#shiftinfo')
							.hide();
						$.ajax(
							'/ajax/publisherlist.php',
							{
								data: data,
								dataType: 'json',
								type: 'POST',
								context: this
							}
						)
						.done(
							function(json) {
								$('#picker')
									.append(
										function() {
											var html = [],
												i,
												data = JSON.parse($('#lightbox').attr('data-slot-data'));
												
												html.push(
														'<li>', 
														'Tra parentesi è indicato turni e disponibilità settimanali',
														'</li>'
														);
													
											for (i in json) {
												
												if (json.hasOwnProperty(i)) {
													
													if (json[i].elsewhere !== '1') {
														
														html.push(
														    
															'<li data-icon-before="', json[i].gender == 'Bro' ? 'I' : 'H', '">',
															'<input type="radio" id="pubid', json[i].publisherid, '" name="publisherid" value="', json[i].publisherid, '"', json[i].assignedtothisshift == '1' ? ' checked' : '' , json[i].spouse > 0 ? ' data-spouseid="' + json[i].spouse + '"' : '' ,'>',
															'<label for="pubid', json[i].publisherid, '">',
															json[i].lastname,
															/* ', ',
															json[i].gender,  */
															' ', 
															json[i].firstname, 
															' (',
															json[i].shiftsassignedthisweek,
															'-',
															json[i].shiftsavailablethisweek,
															') ',
															json[i].i,
															'</label>',
															'</li>'
														);
													}
												}
											}
											return html.join('');
										}
									);
									if (data.publisherid > 0) {
										$('#picker input[name=publisherid]:checked').trigger('change');
									}
							}
						);
					}
				)
				.on( /* To disable text selection on double-click */
					'selectstart',
					'[data-publisherid]',
					false
				)
				.on( /* For touchscreen double-tap emulation */
					'touchstart',
					'[data-publisherid]',
					function(e) {
						var $elem = $(e.target), 
							lastTouch = $elem.data('lastTouch') || 0, 
							now = new Date().getTime(), 
							delta = now - lastTouch;
						delta > 20 && delta < 500 ? $elem.data('lastTouch', 0).trigger('dblclick') : $elem.data('lastTouch', now);
					}
				)
				.on(
					'click',
					'[data-publisherid] a',
					function(e) {
						if ('ontouchstart' in document.documentElement) e.preventDefault();
					}
				);
			$(document)
				.on(
					'selectstart',
					'#lightbox',
					false
				)
				.on(
					'click',
					'#lightbox a.close',
					function (e) {
						$('#lightbox').remove();
						return false;
					}
				)
				.on(
					'change',
					'#picker input[name=publisherid]',
					function (e) {
						var data = JSON.parse($('#lightbox').attr('data-slot-data'));
						data.publisherid = this.value;
						$.ajax(
							'/ajax/publisherpopup.php',
							{
								data: data,
								dataType: 'html',
								type: 'POST',
								context: this
							}
						)
						.done(
							function(html) {
								$('#pubinfo').html(html);
								$('#notes').val(data.notes);
								$('#shiftinfo').show();
								
							}
						);
					}
				)
				
				
				.on(
					'submit',
					'#lightbox form',
					function(e) {
						e.preventDefault();
	
						var publisherid = $('input[name=publisherid]:checked', this).val() | 0,
							confrad = $('input[name=confirmed]:checked', this).val(),
							notes = $('#notes').val(),
							confirmed = confrad === 'c',
							rejected = confrad === 'r',
							deleted = confrad === 'd',
							spouseid = $('input[name=publisherid]:checked', this).attr('data-spouseid') | 0,
							data = JSON.parse($('#lightbox').attr('data-slot-data'));

						data.publisherid = publisherid;
						data.confirmed = confirmed ? 1 : 0;
						data.rejected = rejected ? 1 : 0;
						data.deleted = deleted ? 1 : 0;
						data.notes = notes;
						if (spouseid > 0) data.spouseid = spouseid;
						$.ajax(
							'/ajax/updateassignment.php',
							{
								data: data,
								dataType: 'json',
								type: 'POST',
								context: this
							}
						)
						.done(
							function(json) {
								$('#lightbox').remove();
								$('[data-locationid=' + data.locationid + '] [data-date=' + data.date + '] [data-sessionid=' + data.sessionid + ']')
									.load(
										'/ajax/refreshslot.php',
										data
									);
							}
						);
						return false;
					}
				);
			}
			
			/* Calendar */
			if ($('#calendarform').length > 0) {
				var calchanged = false;

				/* Track changes */
				$('#calendarform').on(
					'change',
					'input, select',
					function (e) {
						calchanged = true;
					}
				);

				/* Prompt to save if leave without saving and have changed something */
				$(window).bind(
					'beforeunload',
					function(e) {
						if (calchanged === true) {
							return "You have not saved your changes. To save your changes click 'Cancel', 'Stay on this page' or similar, and use the save button at the bottom of the page.";
						}
					}
				);
				
				
				
								
				
				
				/* Bodge - fix later */
				$('#calendarform').on(
					'submit',
					function() {
						$(window).unbind('beforeunload');
						
						var slots = $('ul.calendar input[type=checkbox]:checked', this).length,
							locs = $('fieldset:eq(0) input[type=checkbox]:checked', this).length;
						
						if (locs === 0) {
							alert('Please choose a location');
							return false;
						} 
						
						if (slots === 0) {
							return confirm('Non hai scelto nessun turno?');
						} 
					}
				)
								
				/* Add all-day checkboxes */
				$('.calendar:not(.calendar2) > li > ul')
					.before('<p><label><input type="checkbox" value="1" class="allday"> Tutto il giorno</label></p>')
					.each(
						function() {
							if ($('input[type=checkbox]:checked', this).length === $('input[type=checkbox]', this).length) $(this).closest('li').find('input.allday').prop('checked', true);
							if ($('input[type=checkbox]:disabled', this).length) $(this).closest('li').find('input.allday').prop('disabled', true);
						}
					);
					
				$('.calendar').on(
					'change',
					'input[type=checkbox]',
					function(e) {
						var allchecked = true;
						if ($(this).is('.allday')) {
							$(this).closest('li').find('input[type=checkbox]:not(.allday)').prop('checked', this.checked);
						} else {
							$(this).closest('ul').find('input[type=checkbox]:not(.allday)').each(
								function() {
									allchecked = allchecked && this.checked;
								}
							);
							$(this).closest('ul').closest('li').find('input.allday[type=checkbox]').prop('checked', allchecked);
						}
					}
				)
			}
			
			/* Folding for mobile */
			if ($('#pubassign').length > 0) {
				$('#pubassign')
					.find('> li')
					.each(
						function() {
							$('> *:not(h3)', this).wrapAll('<div class="hidden details"></div>');
						}
					)
					.end()
					.on(
						'click',
						'h3',
						function(e) {
							$('+ div', this).toggle();
						}
					);
			}
			
			
			
			/* Check Form */ 
				$('#forminsdati').on(
					'submit',
					function() {
						$(window).unbind('beforeunload');
						var valore=$('input[name=tot]', this).val() | 0,
						    valore1 = $('input[name=pos]', this).val() | 0,
							act = $('input[name=act]', this).val();
						 //alert("INIZIO CONTROLLO SU PAGINA INSDATIFORM "+valore+" -- "+valore1+ "  ** "+act);
						if(act==="D") {
                  			 return confirm('Sei sicuro di voler cancellare questi dati?');
			      		 }
						 
						// 26/5/15 Modificato questo valore per permettere di inserire 0 per le strutture deglli alberghi. Dopo il 31/10/2015 si può ripristinare l'istruzione in quanto l'attività degli aberghi sarà conclusa.
              			//if(valore===0) {
                  		//	 alert("TOTALE: Il campo non può contenere zero");
				 		//	 document.forminsdati.tot.focus();
				 		//	 return false;
                		//}
						
						if(valore==="") {
                  			 alert("TOTALE: Il campo non può essere vuoto");
				 			 document.forminsdati.tot.focus();
				 			 return false;
                		}
						
             			 if(valore1>valore) {
                  	 		 alert("Attenzione il valore del campo POSTAZIONE non puo' essere superiore al valore inserito nel campo TOTALE");
					  		document.forminsdati.pos.focus();
					  		return false; 
               			 }

						 
						 //alert("CONTROLLO SU fine PAGINA INSDATIFORM "+valore+" -- "+valore1+ "  ** "+act);
					}
				);
				
			
			/* Check Form */ 
			
				$('#forminsdep').on(
					'submit',
					function() {
						$(window).unbind('beforeunload');
						var valore=$('input[name=tot]', this).val() | 0,
							dt = $('input[name=dt]', this).val();
							act = $('input[name=act]', this).val();
						 //alert("INIZIO CONTROLLO SU PAGINA INSDATIFORM "+valore+" -- "+valore1+ "  ** "+act);
						if(act==="D") {
                  			 return confirm('Sei sicuro di voler cancellare questi dati?');
			      		 }
						
              			if(valore===0) {
                  			 alert("TOTALE: Il campo non può contenere zero");
				 			 document.forminsdep.tot.focus();
				 			 return false;
                		}
						if(valore==="") {
                  			 alert("TOTALE: Il campo non può essere vuoto");
				 			 document.forminsdep.tot.focus();
				 			 return false;
                		}
						
             			
						 if(dt==="") {
                  			 alert("Data non inserita");
				 			 document.forminsdep.dt.focus();
				 			 return false;
                		}
						 
						 //alert("CONTROLLO SU fine PAGINA INSDATIFORM "+valore+" -- "+valore1+ "  ** "+act);
					}
				);
			
			/* Check Form */ 
			
				$('#datinv').on(
				'change',
				//function() {
				//
				 function(e) {
					$(window).unbind('beforeunload');
     
					var n1 = $("input[name^='sig']").length;
					//alert("length: "+n1);
					var array1 = $("input[name^='sig']");
					var sig = [];
					for(i=0; i < n1; i++) {
  				  		sig_value = array1.eq(i).val();
						sig[i] =  sig_value;
				 		// alert("passo 0: "+sig_value+" n: "+n1+" - i: "+i+" -- sig: "+sig[i]);
					}
								
					var tot = [];
					var n2 = $("input[name^='tot']").length;
					//alert("length tot"+n2);
					$('input[id^="tot"]').each(function(){ tot.push(this.value); }); 
					
				
				 } 
					    )
				
				.on(
					'submit',
					function() {
						$(window).unbind('beforeunload');
						var	act = $('input[name=act]', this).val();

						 var n1 = $("input[name^='sig']").length;
						//alert("length: "+n1);
						var array1 = $("input[name^='sig']");
						var sig = [];
						for(i=0; i < n1; i++) {
  				  			sig_value = array1.eq(i).val();
							sig[i] =  sig_value;
				 			// alert("passo 0: "+sig_value+" n: "+n1+" - i: "+i+" -- sig: "+sig[i]);
						}
						 
					 
						//  ********** CONTROLLO INSERIMENTO CAMPI NEGATIVI O NON NUMERICI***********
						var n2 = $("input[name^='tot']").length;
						//alert("length: "+n2);
						var array2 = $("input[name^='tot']");
						var tot = [];
						for(i=0; i < n2; i++) {
  				  			tot_value = array2.eq(i).val();
							tot[i] =  tot_value;
								if(isNaN(parseInt(tot[i]))) {
									alert("Lingua: "+sig[i]+" - Il campo deve essere numerico: "+tot[i]);
								 return false;
	               				}
								if(tot[i] < 0) {
                  					 alert("Lingua: "+sig[i]+" - Il campo non può essere minore di zero: "+tot[i]);
								 return false;
	               				}
						}
						
						if(act==="I") {
                  			 return confirm('Per confermare la registrazione clicca su OK, altrimenti per ricontrollare i dati inseriti clicca su ANNULLA. ');
			      		 }
						 //alert("CONTROLLO SU fine PAGINA INSDATIFORM "+valore+" -- "+valore1+ "  ** "+act);
					}
				);
				$('#depstores').ready(function() {
					$("input[name^='tot']")[0].focus();
                    
                });
				
				$('#depstores').on(
				'change',
				 function() {
					$(window).unbind('beforeunload');
						var out = [];
						var diff = [];
						var perc = [];
						
						var n0 = $("input[name^='bytotal']").length;
						//alert("length bytotal (numero righe): "+n0);
						var array0 = $("input[name^='bytotal']");
						var bytotal = [];
						for(i=0; i < n0; i++) {
  				  			bytotal_value = array0.eq(i).val();
							bytotal[i] =  bytotal_value;
							out[i] = 0;
							
				 			// alert("passo 0: "+bytotal_value+" n: "+n0+" - i: "+i);
						}						
					  
				        var n1 = $("input[name^='sigla']").length;
						var array1 = $("input[name^='sigla']");
						var sigla = [];
					
					
					  	var n2 = $("input[name^='storeid']").length;
						var array2 = $("input[name^='storeid']");
						var storeid = [];
					
						
						var n3 = $("input[name^='byrow']").length;
						var array3 = $("input[name^='byrow']");
						var byrow = [];
									
						
						for(i=0; i < n1; i++) {
  				  			sigla_value = array1.eq(i).val();
							sigla[i] =  sigla_value;
							storeid_value = array2.eq(i).val();
							storeid[i] =  storeid_value;
							byrow_value = array3.eq(i).val();
							byrow[i] =  byrow_value;
							diff[i] = 0;
							perc[i] = 0;
							//alert(" sigla: "+sigla_value+" - storeid: "+storeid_value+" - byrow: "+byrow_value);
						}	
						
					 	var tot = [];
						var n99 = $('input[id^="tot"]').length;
						var ind = 0;
						 $('input[name="tot[]"]').each(function() { 
						 	var aValue = $(this).val(); 
						 	tot[ind] = aValue;
							//alert(" - avalue = "+aValue+" - tvalue = "+tValue+" - indice= "+ind+" ** tot[]: "+tot[ind]+" ** byrow: "+byrow[ind]+" ** sigla: "+sigla[ind]+" ** storeid: "+storeid[ind]);
							ind++;
						});
						
						 var loc1 = $('input[id^="nloc"]').length;
						 var loc = $('input[id^="nloc"]').val();
						 //alert(" loc: "+loc+" -- "+loc1);
						 ind = 0;
						 var rowind = 0;
						 var rowelem = loc;
						 var tValue = 0;
						 var tPerc = 0;
						 // elaborazione di tutti i campi tot e calcola il totale out per riga e la rimanenza
						 for(i = 0; i < n99; i++) {
							 if(i < rowelem) {
							 } else {
								 ind++;
								 rowelem = parseInt(rowelem) + parseInt(loc);
								 tValue = 0;
								// alert(" rowelement: "+rowelem+" - loc= "+loc+" * ind= "+ind);
							}
							if(tot[i] === "") {
								//alert(" *** not a number - i: "+i);
							} else {
							      tValue = parseInt(tValue);
							      tValue = tValue + parseInt(tot[i]);
								  out[ind] =+ tValue;
								  //alert(" calcolo out: "+out[ind]+" - indice: "+ind);
									tPerc = parseInt(tot[i]) / parseInt(bytotal[ind]) * parseInt(100);
									tPerc = parseInt(tPerc);
									//alert (" perc: "+tPerc);
									perc[i] = tPerc;
							}
						 }
						 
						tValue =0;
						for (i = 0; i < n0; i++) {
							tValue = parseInt(tValue);
							tValue = tValue + parseInt(bytotal[i]) - parseInt(out[i]);	
							diff[i] = tValue;
							irow = i;
							irow++;
							//alert(" i: "+i+" -byrow: "+byrow[i]+" bytotal: "+bytotal[i]+" ** out: "+out[i]+" ** diff: "+diff[i]);
							if(diff[i] < 0) {
								alert("Attenzione: le uscite non possono minori di zero! "+"\n"+"Riga "+irow+" - Valore: "+diff[i]);
							}
							tValue = 0;
						}
						
						arr = $('tbody tr td#out').map(function(i, el) {
							// alert(" - Map out: i: "+i+" - el: "+el);
  							return $(el).text(out[i]);
						});
								
						arr1 = $('tbody tr td#diff').map(function(i, el) {
							//alert(" - Map diff: i: "+i+" - el: "+el);
  							return $(el).text(diff[i]);
						}).get();
								
						arr2 = $('tbody tr td span#perc').map(function(i, el) {
							//alert(" - Map diff: i: "+i+" - el: "+el);
  							return $(el).text(perc[i]);
						}).get();
					   } 
					    )
					   
				.on(
				'submit',
					function() {
						$(window).unbind('beforeunload');
						var	act = $('input[name=act]', this).val();
						var	publication = $('input[name=publication]', this).val();
						var	nloc = $('input[name=nloc]', this).val();
						var finalcheck = 0;
						//alert(nloc+" -- ");
						var n1 = $("input[name^='sig']").length;
						//alert("length sig: "+n1);
						var array1 = $("input[name^='sig']");
						var sig = [];
						for(i=0; i < n1; i++) {
  				  			sig_value = array1.eq(i).val();
							sig[i] =  sig_value;
				 			// alert("passo 0: "+sig_value+" n: "+n1+" - i: "+i+" -- sig: "+sig[i]);
						}
						
						var diff = [];
						var n0 = $('tbody tr td#diff').length;
						//alert("length diff: "+n0);
						var array0 = $('tbody tr td#diff');
						for(i=0; i < n0; i++) {
							var diff_value = array0.eq(i).text();
							diff[i] =  diff_value;
							irow = i;
							irow++;
							ifield = i * nloc;
							if(diff_value < 0) {
								
								alert("La differenza tra il deposito e le uscite non può essere un valore minore di zero! "+"\n"+" riga: "+irow+" - valore: "+diff_value);
								$("input[name^='tot']")[ifield].focus();
								return false;
							}
						}
						
						//  ********** CONTROLLO INSERIMENTO CAMPI NEGATIVI O NON NUMERICI***********
						var n2 = $("input[name^='tot']").length;
						//alert("length tot: "+n2);
						var array2 = $("input[name^='tot']");
						var tot = [];
						for(i=0; i < n2; i++) {
  				  			tot_value = array2.eq(i).val();
							tot[i] =  tot_value;
							if(tot[i] != "") {
								if(isNaN(parseInt(tot[i]))) {
									alert("Lingua: "+sig[i]+" - Il campo deve essere numerico: "+tot[i]);
									$("input[name^='tot']")[i].focus();
								 return false;
	               				}
								if(tot[i] < 0) {
                  					 alert("Lingua: "+sig[i]+" - Il campo non può essere minore di zero: "+tot[i]);
									 $("input[name^='tot']")[i].focus();
								 return false;
	               				}
							}
						}
						
                  		return confirm('Per confermare la registrazione clicca su OK, altrimenti per ricontrollare i dati inseriti clicca su ANNULLA. ');
					}
				);
				
			$('#deletedb').on(
				'click',
				function(e) {
					return confirm('Sei sicuro di voler cancellare questi dati?');
				}
			);
				
				
			/* SMS charge notification */
			$('#sendsms').on(
				'click',
				function(e) {
					return confirm('Are you sure you want to send the SMS? This will incur a charge.');
				}
			);
		}
	);
}
