
			$(document).on("click", "a.compare-label", function() {
				apId = $(this).attr("id");
				apId = apId.replace("compare_label", "");

				if ($(this).attr("data-rel-compare") == "false") {
					if (apId) {
						var checkboxCompare = $("#compare_check"+apId);

						if (checkboxCompare.is(":checked"))
							checkboxCompare.prop("checked", false);
						else {
							checkboxCompare.prop("checked", true);
						}
						addCompare(apId);
					}
				}
			});

			$(document).on("change", ".compare-check", function() {
				apId = $(this).attr("id");
				apId = apId.replace("compare_check", "");

				addCompare(apId);
			});

			function addCompare(apId) {
				apId = apId || 0;

				if (apId) {
					var controlCheckedCompare = $("#compare_check"+apId).prop("checked");

					if (!controlCheckedCompare) {
						deleteCompare(apId);
					}
					else {
						$.ajax({
							type: "POST",
							url: "/starlightadmin-20/comparisonList/main/add",
							data: {apId: apId},
							beforeSend: function(){

							},
							success: function(html){
								if (html == "ok") {
									$("#compare_label"+apId).html("In the comparison list");
									$("#compare_label"+apId).prop("href", "/starlightadmin-20/comparisonList");
									$("#compare_label"+apId).attr("data-rel-compare", "true");
								}
								else {
									$("#compare_check"+apId).prop("checked", false);

									if (html == "max_limit") {
										$("#compare_label"+apId).html("Maximum 6 listings");
									}
									else {
										$("#compare_label"+apId).html("Error");
									}
								}
							}
						});
					}
				}
			}

			function deleteCompare(apId) {
				$.ajax({
					type: "POST",
					url: "/starlightadmin-20/comparisonList/main/del",
					data: {apId: apId},
					success: function(html){
						if (html == "ok") {
							$("#compare_label"+apId).html("Add to a comparison list ");
							$("#compare_label"+apId).prop("href", "javascript:void(0);");
							$("#compare_label"+apId).attr("data-rel-compare", "false");
						}
						else {
							$("#compare_check"+apId).prop("checked", true);
							$("#compare_label"+apId).html("Error");
						}
					}
				});
			}
		