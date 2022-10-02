
jQuery(function($) {

    'use strict';
	
		<!--agenda-->
		
		
		<!--end agenda-->
		$("#con_contributor").select2({
															placeholder: 'Choisissez',
															allowClear: true
														}).on('select2-open', function() {
															// Adding Custom Scrollbar
															$(this).data('select2').results.addClass('overflow-hidden').perfectScrollbar();
														});
														<!---->
													$("#contributor").select2({
															placeholder: 'Choisissez',
															allowClear: true
														}).on('select2-open', function() {
															// Adding Custom Scrollbar
															$(this).data('select2').results.addClass('overflow-hidden').perfectScrollbar();
														});
														<!---->
													$("#con_adversary").select2({
															placeholder: 'Choisissez',
															allowClear: true
														}).on('select2-open', function() {
															// Adding Custom Scrollbar
															$(this).data('select2').results.addClass('overflow-hidden').perfectScrollbar();
														});
													<!---->
													 $("#adversary").select2({
															placeholder: 'Choisissez',
															allowClear: true
														}).on('select2-open', function() {
															// Adding Custom Scrollbar
															$(this).data('select2').results.addClass('overflow-hidden').perfectScrollbar();
														});
														<!---->
													 $("#corresponding").select2({
															placeholder: 'Choisissez',
															allowClear: true
														}).on('select2-open', function() {
															// Adding Custom Scrollbar
															$(this).data('select2').results.addClass('overflow-hidden').perfectScrollbar();
														});
														<!---->
													 $("#id_client").select2({
															placeholder: 'Choisissez',
															allowClear: true
														}).on('select2-open', function() {
															// Adding Custom Scrollbar
															$(this).data('select2').results.addClass('overflow-hidden').perfectScrollbar();
														});

		<!--*********-->
		  var responsiveHelper = undefined;
                var breakpointDefinition = {
                    tablet: 1024,
                    phone: 480
                };
                var tableElement = $('#dataprestation');

                tableElement.dataTable({
                    "sDom": "<'row'<'col-md-6'l T><'col-md-6'f>r>t<'row'<'col-md-12'p i>>",
                    "oTableTools": {
                        "aButtons": [{
                            "sExtends": "collection",
                            "sButtonText": "<i class='fa fa-cloud-download'></i>",
                            "aButtons": ["csv", "xls", "pdf", "copy"]
                        }]
                    },
                    "sPaginationType": "bootstrap",
                   "aoColumnDefs": [
					  { 'bSortable': false, 'aTargets': [ "no-sort" ] }
					],
					"fnInitComplete": function(oSettings, json) { 
					  $('.dataTables_filter input').attr("placeholder", "Recherche");
					},
								"aaSorting": [
                        [1, "desc"]
                    ],
                   "oLanguage": {
			 			"oPaginate": {
							"sNext": "Suivant",
							"sPrevious": "Précédent"
						  },
			 			"sSearch": "",
						"sEmptyTable": "Aucun enregistrement trouvé",
			 			"sInfoFiltered": " - filtré de _MAX_ résultats",
						"infoEmpty": "Aucun résultats trouvé",
                        "sLengthMenu": "_MENU_ ",
                        "sInfo": "Montrer _START_ à _END_ de _TOTAL_ résultats",
						"sLengthMenu": "_MENU_",
						"sZeroRecords": "Aucun enregistrement à afficher"
						
                    },
                    bAutoWidth: false,
                    fnPreDrawCallback: function() {
                        // Initialize the responsive datatables helper once.
                        if (!responsiveHelper) {
                            //responsiveHelper = new ResponsiveDatatablesHelper(tableElement, breakpointDefinition);
                        }
                    },
                    fnRowCallback: function(nRow) {
                        //responsiveHelper.createExpandIcon(nRow);
                    },
                    fnDrawCallback: function(oSettings) {
                        //responsiveHelper.respond();
                    }
                });
				<!---->
				$('#dataevent').dataTable({
                    "sDom": "<'row'<'col-md-6'l T><'col-md-6'f>r>t<'row'<'col-md-12'p i>>",
                    "oTableTools": {
                        "aButtons": [{
                            "sExtends": "collection",
                            "sButtonText": "<i class='fa fa-cloud-download'></i>",
                            "aButtons": ["csv", "xls", "pdf", "copy"]
                        }]
                    },
                    "sPaginationType": "bootstrap",
                   "aoColumnDefs": [
					  { 'bSortable': false, 'aTargets': [ "no-sort" ] }
					],
					"fnInitComplete": function(oSettings, json) { 
					  $('.dataTables_filter input').attr("placeholder", "Recherche");
					},
								"aaSorting": [
                        [1, "desc"]
                    ],
                   "oLanguage": {
			 			"oPaginate": {
							"sNext": "Suivant",
							"sPrevious": "Précédent"
						  },
			 			"sSearch": "",
						"sEmptyTable": "Aucun enregistrement trouvé",
			 			"sInfoFiltered": " - filtré de _MAX_ résultats",
						"infoEmpty": "Aucun résultats trouvé",
                        "sLengthMenu": "_MENU_ ",
                        "sInfo": "Montrer _START_ à _END_ de _TOTAL_ résultats",
						"sLengthMenu": "_MENU_",
						"sZeroRecords": "Aucun enregistrement à afficher"
						
                    },
                    bAutoWidth: false,
                    fnPreDrawCallback: function() {
                        // Initialize the responsive datatables helper once.
                        if (!responsiveHelper) {
                            //responsiveHelper = new ResponsiveDatatablesHelper(tableElement, breakpointDefinition);
                        }
                    },
                    fnRowCallback: function(nRow) {
                        //responsiveHelper.createExpandIcon(nRow);
                    },
                    fnDrawCallback: function(oSettings) {
                        //responsiveHelper.respond();
                    }
                });
				
				 $('#example_wrapper .dataTables_filter input').addClass("input-medium "); // modify table search input
                $('#example_wrapper .dataTables_length select').addClass("select2-wrapper col-md-12"); // modify table per page dropdown



                $('#dataprestation input').click(function() {
                    $(this).parent().parent().parent().toggleClass('row_selected');
                });
				<!--++++++++++delete+++++++++++-->
				
												
	  });
	  
	 