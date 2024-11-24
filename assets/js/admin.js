jQuery(document).ready(function ($) {
	/*Delete Leads*/
	$(".delete-lead").on("click", function (e) {
		e.preventDefault();
		var id = $(this).data("id");

		$.ajax({
			url: THRAIL.ajaxurl,
			method: "POST",
			data: {
				action: "delete_lead",
				id: id,
				nonce: THRAIL.nonce,
			},
			dataType: "JSON",
			success: function (response) {
				alert(response.data.message);
				location.reload();
			},
			error: function (response) {
				console.log(response);
			},
		});
	});

	/*Edit Leads*/
	var edit_lead_modal = $("#edit_lead");
	edit_lead_modal.dialog({
		autoOpen: false,
		height: 300,
		width: 350,
		modal: true,
		buttons: {
			"Save changes": function () {
				updateLead();
			},
			Cancel: function () {
				$(this).dialog("close");
			},
		},
	});

	$(document).on("click", ".edit-lead", function (e) {
		e.preventDefault();
		var $currentRow = $(this).closest("tr");

		$("#lead_id").val($(this).data("id"));
		$("#lead_name").val($currentRow.find(".name-column").text());
		$("#lead_email").val($currentRow.find(".email-column").text());
		edit_lead_modal.dialog("open");
	});

	function updateLead() {
		var postData = {
			action: "update_lead",
			id: $("#lead_id").val(),
			name: $("#lead_name").val(),
			email: $("#lead_email").val(),
			nonce: THRAIL.nonce,
		};

		$.ajax({
			url: THRAIL.ajaxurl,
			method: "POST",
			data: postData,
			success: function (response) {
				if (response.success) {
					alert("Lead updated successfully");
					location.reload();
				} else {
					alert("Error: " + response.data.message);
				}
			},
			error: function (xhr, status, error) {
				alert("AJAX error: " + error);
			},
		});
	}

	$("#thrail-crm-email-settings-form").on("submit", function (e) {
		e.preventDefault();
		var loader = $("#formLoader");
		loader.show();
		var formData = $(this).serialize();
		$.ajax({
			url: THRAIL.rest_base + "/update-email-settings/",
			method: "POST",
			data: formData,
			success: function (response) {
				console.log(response);
				loader.hide();
			},
			error: function (response) {
				console.log(response);
				loader.hide();
			},
		});
	});
});
