
						function doSearchAction() {
						    if($("#search_term_text").length){
                                var term = $(".search-term input#search_term_text").val();
                                if (term.length < 4 || term == "Search by description or address") {
                                    $(".search-term input#search_term_text").attr("disabled", "disabled");
                                }
							}

							$("#search-form").submit();
						}
					